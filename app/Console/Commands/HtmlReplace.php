<?php

namespace App\Console\Commands;

use App\Jobs\HtmlSecond;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class HtmlReplace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'html:xsj';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add xiasuiji(); to html';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $disk = Storage::disk('html');
        foreach ($disk->directories() as $directory) {
            dispatch(new HtmlSecond($directory));
        }
    }
}
