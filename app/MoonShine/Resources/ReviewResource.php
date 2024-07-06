<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Number;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<Review>
 */
class ReviewResource extends ModelResource
{
    protected string $model = Review::class;

    protected string $title = 'Отзывы';

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 15; // Количество элементов на странице

    public string $column = 'name'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $saveFilterState = true;

    protected bool $isAsync = true;

    public function search(): array
    {
        return ['id', 'full_name', 'message',];
    }

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->showOnExport(),
                Text::make('ФИО', 'full_name')->sortable()->showOnExport(),
                Text::make('Сообщение', 'message')->showOnExport(),
                Number::make('Рейтинг', 'rating')->sortable()->showOnExport(),
                Switcher::make('Опубликован', 'isPublished')->showOnExport(),
                Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->hideOnForm(),
                Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->hideOnForm(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'rating' => 'required|numeric|integer',
            'isPublished' => 'required|boolean',
        ];
    }

    public function filters(): array
    {
        return [

            Text::make('ФИО', 'full_name')->nullable(),

            Text::make('Сообщение','message')->nullable(),

            Switcher::make('Опубликован','isPublished')->nullable(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

        ];
    }
}
