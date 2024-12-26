<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('buku', 100);
            $table->integer('tahun_terbit');
            $table->integer('jumlah');
            $table->string('isbn', 45);
            $table->unsignedBigInteger('pengarang_id');
            $table->unsignedBigInteger('penerbit_id');
            $table->string('kode_rak', 10);
            $table->timestamps();

            $table->foreign('pengarang_id')->references('id')->on('pengarangs')->onDelete('CASCADE');
            $table->foreign('penerbit_id')->references('id')->on('penerbits')->onDelete('CASCADE');
            $table->foreign('kode_rak')->references('kode_rak')->on('raks')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
