<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $products = collect($data['products']);

        unset($data['products']);

        $total = $products->sum(function (array $product) {

            $productPrice = Product::query()->findOrFail($product['id']);

            return $productPrice['price'] * $product['count'];

        });

        $data['total'] = $total;

        $cart = DB::transaction(function () use ($request, $data, $products) {

            $cart = Cart::query()->create($data);

            $products->each(function (array $product, int $key) use ($cart) {
                Order::query()->create([
                    'cart_id' => $cart->id,
                    'product_id' => $product['id'],
                    'count' => $product['count'],
                ]);
            });

            return $cart;

        }, 3);

//        Mail::to($data['email'])->send(new \App\Mail\Order($cart, 'успешно оформлен. Ожидайте модерацию администратором.', 'Оформление заказа'));

        return new CartResource($cart);
    }
}
