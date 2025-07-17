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
        Schema::create('protocols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('judul');
            $table->enum('subjek_penelitian',['Manusia','Data Sekunder','In Vitro']);
            $table->enum('jenis_penelitian',['Multicenter','Eksperimental Human','Eksperimental Non Human','Observasional Human','Observasional Non Human','In Vitro']);
            $table->enum('jenis_pengajuan',['Telaah Awal','Pengiriman Ulang Untuk Telaah Ulang','Amandemen Protokol','Telaah Lanjutan Untuk Protokol Yang disetujui', 'Penghentian Studi']);
            $table->enum('biaya_penelitian',['Sponsor','Mandiri']);
            $table->enum('status_penelitian',['Diperiksa','Ditelaah','Dikembalikan','Selesai'])->default('diperiksa');
            $table->string('va')->nullable();
            $table->string('va_slash')->nullable();
            $table->string('nomor_protokol')->nullable();
            $table->string('nomor_protokol_asli')->nullable();
            $table->string('tarif')->nullable();
            $table->timestamp('verified_pembayaran')->nullable();
            $table->string('path_pembayaran')->nullable();
            $table->enum('status_pembayaran',['Menunggu Pembayaran','Diperiksa', 'Diterima', 'Dikembalikan'])->default('Menunggu Pembayaran');
            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->enum('kategori_review',['Belum Dikategorikan','Exempted','Expedited','Fullboard'])->default('Belum Dikategorikan');
            $table->enum('status_telaah',['Telaah Awal','Telaah Lanjutan', 'Telaah Akhir','Selesai'])->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protocols');
    }
};
