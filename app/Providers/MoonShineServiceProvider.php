<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Status;
use App\MoonShine\Resources\CartResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\DeliveryResource;
use App\MoonShine\Resources\ImageResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\ReviewResource;
use App\MoonShine\Resources\StatusResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Системные настройки', [
               MenuItem::make(
                   'Администраторы',
                   new MoonShineUserResource()
               ),
               MenuItem::make(
                   'Роли',
                   new MoonShineUserRoleResource()
               ),
            ]),
            MenuGroup::make('Управление сайтом', [
                MenuItem::make('Товары', new ProductResource())->icon('heroicons.outline.building-storefront')->badge(fn() => Product::query()->count()),
                MenuItem::make('Изображения', new ImageResource())->icon('heroicons.outline.photo')->badge(fn() => Image::query()->count()),
                MenuItem::make('Тип доставки', new DeliveryResource())->icon('heroicons.outline.map-pin')->badge(fn() => Delivery::query()->count()),
                MenuItem::make('Статус заказа', new StatusResource())->icon('heroicons.outline.megaphone')->badge(fn() => Status::query()->count()),
                MenuItem::make('Категории', new CategoryResource())->icon('heroicons.outline.tag')->badge(fn() => Category::query()->count()),
                MenuItem::make('Отзывы', new ReviewResource())->icon('heroicons.outline.hand-thumb-up')->badge(fn() => Review::query()->count()),
                MenuItem::make('Заказы', new CartResource())->icon('heroicons.outline.credit-card')->badge(fn() => Cart::query()->count()),
                MenuItem::make('Товары корзины', new OrderResource())->icon('heroicons.outline.circle-stack')->badge(fn() => Order::query()->count()),
            ])
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
