<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Predis\Client;

class HtmlFile implements ShouldQueue
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

        $html = $disk->get($this->path);

        if (false !== strpos($html, 'xiasuiji')) {
            return;
        }

        $html = str_replace('tj();', 'tj();xiasuiji();', $html);

        if ($disk->put($this->path, $html)) {
            $rds->sadd($key, $this->path);
        }
    }
}
