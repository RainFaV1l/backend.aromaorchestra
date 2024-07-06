<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Delivery;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<Delivery>
 */
class DeliveryResource extends ModelResource
{
    protected string $model = Delivery::class;

    protected string $title = 'Тип доставки';

    public string $column = 'name'; // Поле для отображения значений в связях и хлебных крошках

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected array $with = ['carts'];

    protected bool $isAsync = true;

    public function search(): array
    {
        return ['id', 'name'];
    }

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->showOnExport(),
                Text::make('Название', 'name')->sortable()->showOnExport(),
                Number::make('Цена', 'price')->sortable()->showOnExport(),
                Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->hideOnForm(),
                Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->hideOnForm(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }

    public function filters(): array
    {
        return [

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

        ];
    }
}
