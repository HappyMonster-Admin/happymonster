<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Forms\Components\barcode;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make()
                    ->schema([
                        // ...
                        TextInput::make('article_name'),
                        TextInput::make('hmb')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100),
                        TextInput::make('pa')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100),
                        TextInput::make('slug'),
                        TextInput::make('price')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100),
                        DatePicker::make('sales_start_date'),
                        TextInput::make('article_per_package')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100),
                    ]),
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('Description')
                            ->schema([
                                // ...
                                FileUpload::make('image'),
                                Textarea::make('short_description'),
                                MarkdownEditor::make('description'),
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
                                barcode::make('barcode'),
                            ]),
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
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Options')
                            ->schema([
                                // ...
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
