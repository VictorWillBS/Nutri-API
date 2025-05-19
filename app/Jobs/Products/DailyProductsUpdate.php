<?php

namespace App\Jobs\products;

use App\Modules\Products\Repositories\Products;
use App\Modules\Products\Services\ProductSyncer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Redis\RedisManager;

class DailyProductsUpdate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        Products $products,
        RedisManager $redis,
        ProductSyncer $syncer,
    ): void {
        $products->allAbleToDailyUpdate()
            ->each(function ($product) use($syncer) {
                $data = $syncer->getProductData($product->code);
                $product->fill($data);
                $product->synced_at = now()->format('Y-m-d H:i:s');
                $product->save();
            });

        $redis->set('cron_last_execution', now()->toDateString());
    }
}
