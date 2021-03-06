<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBeaTitipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bea_titip', function (Blueprint $table) {
            // $table->integer('biaya_titip_ke')->default(0);
            $table->double('kredit')->default(0);
            $table->double('saldo')->default(0);
            // menentukan logika tampil tidak di fungsi data pembayaran > pendapatan
            $table->integer('status_pendapatan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bea_titip', function (Blueprint $table) {
            //
        });
    }
}
