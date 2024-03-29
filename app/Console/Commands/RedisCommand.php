<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $before = microtime(true);

        Cache::get('products:all');

        $after = microtime(true);

        dd($after - $before);
    }
}
