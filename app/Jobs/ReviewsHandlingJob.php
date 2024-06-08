<?php

namespace App\Jobs;

use App\Http\Services\Product\SaveProductData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReviewsHandlingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected SaveProductData $saveProductData;
    /**
     * Create a new job instance.
     */
    public function __construct(SaveProductData $saveProductData, $url)
    {
        $this->url = $url;
        $this->saveProductData = $saveProductData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->saveProductData->save($this->url);
        sleep(5);
    }
}
