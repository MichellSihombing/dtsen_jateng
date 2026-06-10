<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
   /*
   |--------------------------------------------------------------------------
   | MENJALANKAN SEEDER
   |--------------------------------------------------------------------------
   */
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA DESA
        |--------------------------------------------------------------------------
        */
        $desas = Wilayah::where('tingkat', 'desa')->get();
        
        /*
        |--------------------------------------------------------------------------
        | CEK DATA DESA
        |--------------------------------------------------------------------------
        */
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA DESA
        |--------------------------------------------------------------------------
        */
        if ($desas->count() == 0) {
            $semarangTengah = Wilayah::where('kode_wilayah', '33.71.01')->first();
            if ($semarangTengah) {
                /*
                |--------------------------------------------------------------------------
                | DATA DESA SAMPLE
                |--------------------------------------------------------------------------
                */
                $desasSample = [
                    ['33.71.01.001', 'Pekunden', 'desa', $semarangTengah->id],
                    ['33.71.01.002', 'Karangtempel', 'desa', $semarangTengah->id],
                    ['33.71.01.003', 'Miroto', 'desa', $semarangTengah->id],
                    ['33.71.01.004', 'Pindrikan Kidul', 'desa', $semarangTengah->id],
                    ['33.71.01.005', 'Pindrikan Lor', 'desa', $semarangTengah->id],
                ];
                
                /*
                |--------------------------------------------------------------------------
                | SIMPAN DESA SAMPLE
                |--------------------------------------------------------------------------
                */
                foreach ($desasSample as $desa) {
                    Wilayah::create([
                        'kode_wilayah' => $desa[0],
                        'nama' => $desa[1],
                        'tingkat' => $desa[2],
                        'parent_id' => $desa[3],
                        'geojson' => null
                    ]);
                }
            }
            $desas = Wilayah::where('tingkat', 'desa')->get();
        }
        
        if ($desas->count() == 0) {
            $this->command->warn('Tidak ada data desa. Jalankan WilayahSeeder dengan desa terlebih dahulu!');
            return;
        }
        
        /*
        |--------------------------------------------------------------------------
        | SIAPKAN DATA PENDUDUK
        |--------------------------------------------------------------------------
        */
        $dataPenduduk = [];
        /*
        |--------------------------------------------------------------------------
        | DATA NAMA DUMMY
        |--------------------------------------------------------------------------
        */
        $namaDepan = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hesti', 'Irfan', 'Joko', 'Kartika', 'Lina', 'Mulyono', 'Nina', 'Oscar', 'Putri', 'Qori', 'Rina', 'Siti', 'Tono'];
        $namaBelakang = ['Santoso', 'Wijaya', 'Pratiwi', 'Kurniawan', 'Hidayat', 'Nugroho', 'Saputra', 'Susanti', 'Purnomo', 'Rahayu', 'Setiawan', 'Kusuma', 'Gunawan', 'Utami', 'Wibowo'];
        
        /*
        |--------------------------------------------------------------------------
        | GENERATE DATA PENDUDUK
        |--------------------------------------------------------------------------
        */
        foreach ($desas as $desa) {
            for ($i = 1; $i <= 10; $i++) {
                $nik = '33' . rand(10, 99) . rand(1000, 9999) . rand(100, 999) . rand(10, 99);
                $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
                $usia = rand(0, 80);
                $desil = rand(1, 10);
                
                $dataPenduduk[] = [
                    'nik' => $nik,
                    'nama' => $nama,
                    'desa_id' => $desa->id,
                    'desil' => $desil,
                    'rlth' => rand(0, 1),
                    'jamban' => rand(0, 1),
                    'ats' => rand(0, 1),
                    'tidak_bekerja' => rand(0, 1),
                    'air_bersih' => rand(0, 1),
                    'listrik' => rand(0, 1),
                    'disabilitas' => rand(0, 1),
                    'usia' => $usia,
                    'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                    'pkh' => $desil <= 3 ? rand(0, 1) : 0,
                    'sembako' => $desil <= 4 ? rand(0, 1) : 0,
                    'pbi' => $desil <= 5 ? rand(0, 1) : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA BATCH
        |--------------------------------------------------------------------------
        */
        foreach (array_chunk($dataPenduduk, 50) as $chunk) {
            Penduduk::insert($chunk);
        }
        
        /*
        |--------------------------------------------------------------------------
        | INFO HASIL SEEDER
        |--------------------------------------------------------------------------
        */
        $this->command->info('✅ ' . count($dataPenduduk) . ' data penduduk berhasil di-seed!');
    }
}
