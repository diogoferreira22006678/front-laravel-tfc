<?php

namespace App\Console\Commands;

use App\Api\CoreApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MakeApiCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an API call every minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Core api
        $response = Http::get('https://api.example.com/endpoint');

        if($response->successful()){
            $this->info('Success');
        }
        else{
            $this->error('Error');
        }


    }
}
