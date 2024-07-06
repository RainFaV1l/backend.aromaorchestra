<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Number;
use MoonShine\Fields\RangeSlider;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<Order>
 */
class OrderResource extends ModelResource
{
    protected string $model = Order::class;

    protected string $title = 'Заказы';

    protected array $with = ['product', 'cart'];

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 15; // Количество элементов на странице

    public string $column = 'id'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $saveFilterState = true;

    protected bool $isAsync = true;

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->showOnExport(),
                BelongsTo::make('Номер заказа', 'cart', resource: new CartResource())->searchable()->showOnExport(),
                BelongsTo::make('Продукт', 'product', resource: new ProductResource())->searchable()->showOnExport(),
                Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->hideOnForm(),
                Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->hideOnForm(),
            ]),
        ];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function rules(Model $item): array
    {
        return [
            'cart_id' => 'required|integer|exists:carts,id',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }

    public function filters(): array
    {
        return [

            BelongsTo::make('Номер заказа', 'cart', resource: new CartResource())->nullable()->searchable()->showOnExport(),

            BelongsTo::make('Продукт', 'product', resource: new ProductResource())->nullable()->searchable()->showOnExport(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

        ];
    }
}
