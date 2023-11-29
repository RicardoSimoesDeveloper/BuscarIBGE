<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $endpoint = "http://servicodados.ibge.gov.br/api/v1/localidades/estados";
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $endpoint);

        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getBody()->getContents());

        if ($statusCode === Response::HTTP_OK) {
            $estados = [];
            DB::beginTransaction();
            foreach ($content as $uf) {
                $estados[] = ['uf' => $uf->sigla, 'nome' => $uf->nome];
            }
            DB::table('estados')->insert($estados);
            DB::commit();
        }
    }
}
