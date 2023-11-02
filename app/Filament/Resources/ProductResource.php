<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Forms\Components\BarCode;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'SHOP';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
{
    return ['article_name', 'reference'];
}

protected static ?string $recordTitleAttribute = 'reference';

protected static int $globalSearchResultsLimit = 20;

public static function getGlobalSearchResultDetails(Model $record): array
{
    return [
        'Article name' => $record->article_name,
        'Reference' => $record->reference,
    ];
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make()
                    ->schema([
                        // ...
                        TextInput::make('article_name')->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function(string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }
                            $set('slug', Str::slug($state));
                        }),
                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                    ])->columns('2'),
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('Description')
                            ->schema([
                                // ...
                                FileUpload::make('image'),
                                Textarea::make('short_description'),
                                MarkdownEditor::make('description'),
                                Section::make('')
                                ->schema([
                                    TextInput::make('hmb'),
                                    TextInput::make('pa'),
                                ])->columns('2'),
                            ]),
                        Tabs\Tab::make('Details')
                            ->schema([
                                // ...
                                TextInput::make('reference')
                                    ->default(random_int(1, 99999999))
                                    ->mask('99999999')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),
                                BarCode::make('barcode')
                                ->label('Bar code'),
                            ])->columns(2),
                        Tabs\Tab::make('Stocks')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Shipping')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Pricing')
                            ->schema([
                                // ...
                                TextInput::make('price')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(100)
                                    ->rules('regex:/^\d{1,6}(\.\d{0,2})?$/')
                                    ->required(),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Options')
                            ->schema([
                                // ...
                                DatePicker::make('sales_start_date'),
                                TextInput::make('article_per_package')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(100),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('reference'),
                ImageColumn::make('image')
                    ->circular(),
                TextColumn::make('article_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hmb')
                    ->label('HMB'),
                TextColumn::make('pa')
                ->label('PA'),
                TextColumn::make('price')
                    ->money('eur')
                    ->sortable()
                    ->toggleable(),
                    IconColumn::make('is_visible')
                    ->sortable()
                    ->toggleable()
                    ->label('Visible')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->sortable()
                    ->toggleable()
                    ->label('Feature')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime('d-m-Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
