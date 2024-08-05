<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearS3Storage extends Command
{
    protected $signature = 'storage:clear-s3';
    protected $description = 'Clear the S3 storage directory';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $disk = Storage::disk('archivos'); // Asumiendo que tu disco S3 se llama 's3'
        $files = $disk->allFiles();

        foreach ($files as $file) {
            $disk->delete($file);
        }

        $this->info('archivos storage cleared successfully.');
    }
}
