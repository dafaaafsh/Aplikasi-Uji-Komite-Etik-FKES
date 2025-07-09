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
        Schema::create('keputusans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('protokol_id');
            $table->enum('hasil_akhir',['Diterima','Ditolak'])->nullable();
            $table->text('komentar')->nullable();
            $table->enum('jenis_penerimaan',['Tanpa Revisi','Revisi Mayor', 'Revisi Minor'])->nullable();
            $table->string('lampiran')->nullable();
            $table->string('path')->nullable();

            $table->timestamps();

            $table->foreign('protokol_id')->references('id')->on('protocols')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keputusans');
    }
};
