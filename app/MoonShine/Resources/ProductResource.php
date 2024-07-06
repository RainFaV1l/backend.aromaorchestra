<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\RangeSlider;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<Product>
 */
class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Товары';

    protected array $with = ['category'];

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 15; // Количество элементов на странице

    public string $column = 'name'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $saveFilterState = true;

    protected bool $isAsync = true;

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->showOnExport(),
                Text::make('Название', 'name')->showOnExport(),
                Textarea::make('Краткое описание', 'short_description')->nullable()->showOnExport()->hideOnIndex(),
                TinyMce::make('Полное описание', 'description')->nullable()->showOnExport()->hideOnIndex(),
                Number::make('Цена', 'price')->sortable()->showOnExport(),
                Image::make('Картинка превью', 'preview_image')->disk('local')->dir('/public')->showOnExport(),
                BelongsTo::make('Категория', 'category', resource: new CategoryResource())->required()->searchable()->showOnExport(),
                Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->hideOnForm(),
                Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->hideOnForm(),
            ]),
        ];
    }

    public function search(): array
    {
        return ['id', 'name', 'short_description', 'description',];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:10000',
            'price' => 'required|numeric|max:1000000',
            'preview_image' => 'nullable|image',
            'category_id' => 'required|int|exists:categories,id',
        ];
    }

    public function filters(): array
    {
        return [

            Text::make('Название', 'name')->nullable(),

            BelongsTo::make('Категория', 'category', resource: new CategoryResource())->searchable()->nullable(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

            RangeSlider::make('Цена', 'price')
                ->min(0)
                ->max(1000000)->nullable(),

        ];
    }
}
