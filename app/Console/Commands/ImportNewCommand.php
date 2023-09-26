<?php

namespace App\Console\Commands;

//use App\Console\Commands\ImportNews;
use Illuminate\Console\Command;

use Maatwebsite\Excel\Facades\Excel;

class ImportNewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'News import';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Your custom command ran successfully!');
        $importFile = 'import-files'.DIRECTORY_SEPARATOR.'news.xlsx';
        if (file_exists(storage_path($importFile))) {
            $tmpFile = storage_path($importFile);
        } else {
            $tmpFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . $importFile);
        }

        $this->info('Importing...');
        $this->info($tmpFile);
        Excel::import(new ImportNews(), $tmpFile);

        $this->info('Completed');
    }
}
