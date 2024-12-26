<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengembalian');
            $table->integer('denda');
            $table->unsignedBigInteger('peminjaman_id');
            $table->unsignedBigInteger('anggota_id');
            $table->unsignedBigInteger('petugas_id');
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('id')->on('peminjaman');
            $table->foreign('anggota_id')->references('id')->on('anggotas');
            $table->foreign('petugas_id')->references('id')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
