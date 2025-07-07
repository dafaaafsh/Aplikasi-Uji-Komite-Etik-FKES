<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProtocolsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1,5),
            'judul' => fake()->sentence(10),
            'subjek_penelitian' => fake()->randomElement(['Manusia','Data Sekunder','In Vitro']),
            'jenis_penelitian' => fake()->randomElement(['Multicenter','Eksperimental Human','Eksperimental Non Human','Observasional Human','Observasional Non Human','In Vitro']),
            'jenis_pengajuan' => fake()->randomElement(['Telaah Awal','Pengiriman Ulang Untuk Telaah Ulang','Amandemen Protokol','Telaah Lanjutan Untuk Protokol Yang disetujui', 'Penghentian Studi']),
            'biaya_penelitian' => fake()->randomElement(['Sponsor','Mandiri']),
            'status_penelitian' => fake()->randomElement(['Diperiksa','Ditelaah','Dikembalikan','Selesai']),
            'nomor_protokol' => fake()->boolean(70)? fake()->unique()->regexify('[A-Z]{3}-[0-9]{3}-[0-9]{2}'):null,
            'verified_pembayaran' => fake()->boolean(90)? fake()->dateTimeBetween('-3 month','now'):null,
            'tanggal_pengajuan' => fake()->boolean(65)? fake()->dateTimeBetween('-3 month','now'):null,
            'kategori_review' => fake()->boolean(65)?fake()->randomElement(['Exempted','Expedited','Fullboard']):'Belum Dikategorikan',
            'created_at' => fake()->dateTimeInInterval('-5 month','+5 month'),
        ];
    }
}
