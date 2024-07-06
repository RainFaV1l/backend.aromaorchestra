<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

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
 * @extends ModelResource<Cart>
 */
class CartResource extends ModelResource
{
    protected string $model = Cart::class;

    protected string $title = 'Заказы';

    protected array $with = ['status', 'delivery', 'orders'];

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
                Text::make('ФИО', 'full_name')->showOnExport(),
                Text::make('Телефон', 'phone')->showOnExport(),
                Text::make('Email', 'email')->showOnExport(),
                BelongsTo::make('Статус', 'status', resource: new StatusResource())->searchable()->showOnExport(),
                BelongsTo::make('Тип', 'delivery', resource: new DeliveryResource())->searchable()->showOnExport(),
                Text::make('Адресс', 'address')->showOnExport(),
                Number::make('Итоговая цена', 'total')->showOnExport(),
                Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->hideOnForm()->hideOnIndex(),
                Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->hideOnForm(),
            ]),
        ];
    }

    public function search(): array
    {
        return ['id', 'full_name', 'phone', 'address', 'total'];
    }

    public function rules(Model $item): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'status_id' => 'required|integer|exists:statuses,id',
            'delivery_id' => 'required|integer|exists:deliveries,id',
            'address' => 'required|string|max:2000',
        ];
    }

    public function filters(): array
    {
        return [

            Text::make('ФИО', 'full_name')->nullable(),

            Text::make('Телефон', 'phone')->nullable(),

            Text::make('Email', 'email')->nullable(),

            Text::make('Адрес', 'address')->nullable(),

            BelongsTo::make('Статус', 'status', resource: new StatusResource())->searchable()->showOnExport(),

            BelongsTo::make('Тип', 'delivery', resource: new DeliveryResource())->searchable()->showOnExport(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

            RangeSlider::make('Итоговая цена', 'total')
                ->min(0)
                ->max(1000000)->nullable(),

        ];
    }
}
