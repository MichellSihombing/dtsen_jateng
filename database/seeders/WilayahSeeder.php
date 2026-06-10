<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        // Provinsi Jawa Tengah
        $jateng = Wilayah::create([
            'kode_wilayah' => '33',
            'nama' => 'Jawa Tengah',
            'tingkat' => 'provinsi',
            'parent_id' => null,
            'geojson' => [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [108.5, -7.8], [111.5, -7.8], [111.5, -6.5], [108.5, -6.5], [108.5, -7.8]
                    ]]
                ]
            ]
        ]);
        
        // Kabupaten/Kota
        $kabupatens = [
            ['33.71', 'Kota Semarang', 'kabupaten', $jateng->id],
            ['33.72', 'Kota Surakarta', 'kabupaten', $jateng->id],
            ['33.73', 'Kota Salatiga', 'kabupaten', $jateng->id],
            ['33.01', 'Kabupaten Cilacap', 'kabupaten', $jateng->id],
            ['33.02', 'Kabupaten Banyumas', 'kabupaten', $jateng->id],
            ['33.03', 'Kabupaten Purbalingga', 'kabupaten', $jateng->id],
            ['33.04', 'Kabupaten Banjarnegara', 'kabupaten', $jateng->id],
            ['33.05', 'Kabupaten Kebumen', 'kabupaten', $jateng->id],
            ['33.06', 'Kabupaten Purworejo', 'kabupaten', $jateng->id],
            ['33.07', 'Kabupaten Wonosobo', 'kabupaten', $jateng->id],
            ['33.08', 'Kabupaten Magelang', 'kabupaten', $jateng->id],
            ['33.09', 'Kabupaten Boyolali', 'kabupaten', $jateng->id],
            ['33.10', 'Kabupaten Klaten', 'kabupaten', $jateng->id],
            ['33.11', 'Kabupaten Sukoharjo', 'kabupaten', $jateng->id],
            ['33.12', 'Kabupaten Wonogiri', 'kabupaten', $jateng->id],
            ['33.13', 'Kabupaten Karanganyar', 'kabupaten', $jateng->id],
            ['33.14', 'Kabupaten Sragen', 'kabupaten', $jateng->id],
            ['33.15', 'Kabupaten Grobogan', 'kabupaten', $jateng->id],
            ['33.16', 'Kabupaten Blora', 'kabupaten', $jateng->id],
            ['33.17', 'Kabupaten Rembang', 'kabupaten', $jateng->id],
            ['33.18', 'Kabupaten Pati', 'kabupaten', $jateng->id],
            ['33.19', 'Kabupaten Kudus', 'kabupaten', $jateng->id],
            ['33.20', 'Kabupaten Jepara', 'kabupaten', $jateng->id],
            ['33.21', 'Kabupaten Demak', 'kabupaten', $jateng->id],
            ['33.22', 'Kabupaten Semarang', 'kabupaten', $jateng->id],
            ['33.23', 'Kabupaten Temanggung', 'kabupaten', $jateng->id],
            ['33.24', 'Kabupaten Kendal', 'kabupaten', $jateng->id],
            ['33.25', 'Kabupaten Batang', 'kabupaten', $jateng->id],
            ['33.26', 'Kabupaten Pekalongan', 'kabupaten', $jateng->id],
            ['33.27', 'Kabupaten Pemalang', 'kabupaten', $jateng->id],
            ['33.28', 'Kabupaten Tegal', 'kabupaten', $jateng->id],
            ['33.29', 'Kabupaten Brebes', 'kabupaten', $jateng->id],
        ];
        
        foreach ($kabupatens as $kab) {
            Wilayah::create([
                'kode_wilayah' => $kab[0],
                'nama' => $kab[1],
                'tingkat' => $kab[2],
                'parent_id' => $kab[3],
                'geojson' => null
            ]);
        }
        
        // Kecamatan untuk Kota Semarang
        $semarang = Wilayah::where('kode_wilayah', '33.71')->first();
        
        $kecamatans = [
            ['33.71.01', 'Semarang Tengah', 'kecamatan', $semarang->id],
            ['33.71.02', 'Semarang Utara', 'kecamatan', $semarang->id],
            ['33.71.03', 'Semarang Timur', 'kecamatan', $semarang->id],
            ['33.71.04', 'Semarang Selatan', 'kecamatan', $semarang->id],
            ['33.71.05', 'Semarang Barat', 'kecamatan', $semarang->id],
            ['33.71.06', 'Gunungpati', 'kecamatan', $semarang->id],
            ['33.71.07', 'Banyumanik', 'kecamatan', $semarang->id],
            ['33.71.08', 'Candisari', 'kecamatan', $semarang->id],
            ['33.71.09', 'Gajahmungkur', 'kecamatan', $semarang->id],
            ['33.71.10', 'Tembalang', 'kecamatan', $semarang->id],
            ['33.71.11', 'Pedurungan', 'kecamatan', $semarang->id],
            ['33.71.12', 'Genuk', 'kecamatan', $semarang->id],
            ['33.71.13', 'Gayamsari', 'kecamatan', $semarang->id],
            ['33.71.14', 'Mijen', 'kecamatan', $semarang->id],
            ['33.71.15', 'Ngaliyan', 'kecamatan', $semarang->id],
            ['33.71.16', 'Tugu', 'kecamatan', $semarang->id],
        ];
        
        foreach ($kecamatans as $kec) {
            Wilayah::create([
                'kode_wilayah' => $kec[0],
                'nama' => $kec[1],
                'tingkat' => $kec[2],
                'parent_id' => $kec[3],
                'geojson' => null
            ]);
        }
        
        $this->command->info('✅ Data wilayah berhasil di-seed!');
    }
}