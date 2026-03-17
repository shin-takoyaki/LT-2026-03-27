<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Ports\OrderRepository;
use App\Application\Ports\PaymentGateway;
use App\Application\Ports\ProductRepository;
use App\Application\Ports\ReceiptPresenter;
use App\Infrastructure\Eloquent\EloquentOrderRepository;
use App\Infrastructure\Eloquent\EloquentProductRepository;
use App\Infrastructure\InMemory\InMemoryProductRepository;
use App\Infrastructure\Payment\FakePaymentGateway;
use App\Infrastructure\Presenters\JsonReceiptPresenter;
use Illuminate\Support\ServiceProvider;

// DIコンテナへ「interface -> 実装クラス」を登録する。
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // UseCaseはinterface型で依存し、実体はここで差し替える。
        $productRepository = $this->app->environment(['local', 'development'])
            ? InMemoryProductRepository::class
            : EloquentProductRepository::class;

        $this->app->bind(ProductRepository::class, $productRepository);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
        $this->app->bind(ReceiptPresenter::class, JsonReceiptPresenter::class);
    }
}
