<?php

namespace App\Http\Middleware;

use App\Http\Resources\AuthUserResource;
use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $cartService = app(CartService::class);
        $totalQuantity = $cartService->getTotalQuantity();
        $totalPrice = $cartService->getTotalPrice();

        $cartItems = $cartService->getCartItems();

        return [
            ...parent::share($request),
            'csrf_token' => csrf_token(),
            'auth' => [
                'user' => $request->user() ? new AuthUserResource($request->user()) : null,
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'success' => [
                'message' => session('success'),
                'time' => microtime(true),
            ],
            'error' => session('error'),
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'miniCartItems' => $cartItems
        ];
    }
}
