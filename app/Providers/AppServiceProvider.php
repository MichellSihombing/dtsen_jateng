<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Events\CommandFinished;

class AppServiceProvider extends ServiceProvider
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER SERVICE
    |--------------------------------------------------------------------------
    */
    public function register(): void
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | BOOT SERVICE
    |--------------------------------------------------------------------------
    */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI SETELAH KEY GENERATE
        |--------------------------------------------------------------------------
        */
        Event::listen(CommandFinished::class, function (CommandFinished $event) {
            if (!app()->runningInConsole()) {
                return;
            }

            if ($event->command !== 'key:generate') {
                return;
            }

            $event->output->writeln('');
            $event->output->writeln('<fg=blue>============================================================</>');
            $event->output->writeln('<fg=blue>SETUP PROJECT DTSEN JAWA TENGAH</>');
            $event->output->writeln('<fg=blue>============================================================</>');
            $event->output->writeln('');
            $event->output->writeln('<fg=yellow>Application key berhasil dibuat.</>');
            $event->output->writeln('<fg=yellow>Setelah itu, jalankan command berikut secara berurutan:</>');
            $event->output->writeln('');
            $event->output->writeln('<fg=green>1. php artisan import:jateng</>');
            $event->output->writeln('<fg=green>2. php artisan import:desil</>');
            $event->output->writeln('<fg=green>3. php artisan geojson:split-jateng</>');
            $event->output->writeln('<fg=green>4. php artisan db:seed</>');
            $event->output->writeln('');
            $event->output->writeln('<fg=cyan>Keterangan:</>');
            $event->output->writeln('<fg=cyan>- import:jateng digunakan untuk import wilayah Jawa Tengah.</>');
            $event->output->writeln('<fg=cyan>- import:desil digunakan untuk import data desil dari Excel.</>');
            $event->output->writeln('<fg=cyan>- geojson:split-jateng digunakan untuk memecah file GeoJSON.</>');
            $event->output->writeln('<fg=cyan>- db:seed digunakan untuk mengisi data master tambahan.</>');
            $event->output->writeln('');
            $event->output->writeln('<fg=white>Opsional:</>');
            $event->output->writeln('<fg=white>- php artisan config:clear  (untuk Menghapus file cache konfigurasi)</>');
            $event->output->writeln('<fg=white>- php artisan config:cache  (Menggabungkan semua file konfigurasi dan nilai .env ke dalam satu file cache)</>');
            $event->output->writeln('<fg=white>- php artisan view:clear    (Menghapus semua file view yang sudah di-compile)</>');
            $event->output->writeln('<fg=white>- php artisan view:cache    (Mengompilasi semua file Blade view menjadi file PHP biasa sekaligus untuk mempercepat rendering halaman. )</>');
            $event->output->writeln('');
            $event->output->writeln('<fg=blue>============================================================</>');
            $event->output->writeln('');
        });
    }
}