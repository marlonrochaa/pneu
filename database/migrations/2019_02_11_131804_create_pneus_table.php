<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePneusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pneus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raio');
            $table->integer('largura');
            $table->integer('perfil');
            $table->integer('status')->default(1);
        });

        Schema::table('pneus', function(Blueprint $table) {
            $table->integer('fk_marca')->unsigned()->nullable();
            $table->foreign('fk_marca')->references('id')->on('marcas')
            ->onDelete('set null');
            
            $table->integer('fk_modelo')->unsigned()->nullable();
            $table->foreign('fk_modelo')->references('id')->on('modelos')
            ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pneus');
    }
}
