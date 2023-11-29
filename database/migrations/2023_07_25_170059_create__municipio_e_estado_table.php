<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados', function(Blueprint $table) {
            $table->id();
            $table->string('uf', 2)->nullable(false);
            $table->string('nome', 30)->nullable(false);
        });

        Artisan::call('db:seed', [
            '--class' => 'EstadosSeeder',
        ]);

        Schema::create('municipios', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado')->nullable(false);
            $table->string('nome', 255)->nullable(false);
            $table->string('ibge', 7)->nullable(false);

            $table->foreign('estado')->references('id')->on('estados');
        });

        Artisan::call('db:seed', [
            '--class' => 'MunicipiosSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('estados');
    }
};
