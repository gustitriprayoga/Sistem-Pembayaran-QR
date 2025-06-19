<?php

namespace Database\Seeders;

use App\Models\DaftarMeja;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\VarianMenu;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $daftarMeja = DaftarMeja::all();
        $varianMenu = VarianMenu::all();

        // =================================================================
        //     PERUBAHAN DI SINI: Mengambil pengguna dengan role 'karyawan'
        // =================================================================
        $penggunaTerdaftar = User::role('karyawan')->get();

        for ($i = 0; $i < 50; $i++) {
            // ... (logika lainnya tetap sama) ...
            $meja = $daftarMeja->random();
            $detailPesananUntukDibuat = [];
            $totalBayar = 0;

            $jumlahJenisItem = rand(1, 3);
            $varianTerpilih = $varianMenu->random($jumlahJenisItem);

            foreach ($varianTerpilih as $varian) {
                $jumlahBeli = rand(1, 2);
                $hargaSatuan = $varian->harga;
                $totalBayar += ($jumlahBeli * $hargaSatuan);

                $detailPesananUntukDibuat[] = [
                    'varian_menu_id' => $varian->id,
                    'jumlah' => $jumlahBeli,
                    'harga_saat_pesan' => $hargaSatuan,
                ];
            }

            $idUser = null;
            $namaPelanggan = null;

            if ($faker->boolean(70)) {
                $namaPelanggan = $faker->name();
            } else {
                if ($penggunaTerdaftar->isNotEmpty()) {
                    $idUser = $penggunaTerdaftar->random()->id;
                } else {
                    $namaPelanggan = $faker->name();
                }
            }

            $statusPesanan = $faker->randomElement(['baru', 'diproses', 'selesai', 'dibatalkan']);
            $statusBayar = ($statusPesanan == 'dibatalkan') ? 'gagal' : 'lunas';

            $pesanan = Pesanan::create([
                'daftar_meja_id' => $meja->id,
                'user_id' => $idUser,
                'nama_pelanggan' => $namaPelanggan,
                'total_bayar' => $totalBayar,
                'status_pesanan' => $statusPesanan,
                'status_bayar' => $statusBayar,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);

            $pesanan->detailPesanan()->createMany($detailPesananUntukDibuat);
        }
    }

}
