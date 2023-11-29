<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = DB::table('estados')->get();

        foreach ($estados as $estado) {
            $endpoint = "http://servicodados.ibge.gov.br/api/v1/localidades/estados/". $estado->uf ."/municipios";
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', $endpoint);

            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody()->getContents());

            if ($statusCode === Response::HTTP_OK) {
                $municipios = [];
                DB::beginTransaction();
                foreach ($content as $municipio) {
                    $municipios[] = [
                        'ibge' => $municipio->id,
                        'nome' => $municipio->nome,
                        'estado' => $estado->id
                    ];
                }
                DB::table('municipios')->insert($municipios);
                DB::commit();
            }
        }
    }
}
