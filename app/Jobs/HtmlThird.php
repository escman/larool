<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Predis\Client;

class HtmlThird implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rds  = new Client();
        $key  = 'HtmlXiaSuiJi';
        $disk = Storage::disk('html');

        foreach ($disk->files($this->path) as $file) {

            if (!preg_match('/[0-9_]+\.html$/', $file)) {
                continue;
            }

            if ($rds->sismember($key, $file)) {
                continue;
            }

            dispatch(new HtmlFile($file));
        }
    }
}
