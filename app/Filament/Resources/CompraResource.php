<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompraResource\Pages;
use App\Filament\Resources\CompraResource\RelationManagers;
use App\Models\Compra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('detalle_compra')
                    ->required()
                    ->maxLength(191),
                 Forms\Components\Select::make('producto_id')
                ->relationship('producto', 'nombre')
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('stock_actual', \App\Models\Producto::find($state)?->stock ?? 0)
                )
                ->required(),
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric()
                ->reactive(),
            Forms\Components\Placeholder::make('stock_actual')
                ->label('Stock Actual')
                ->content(fn ($get) => $get('stock_actual') ?? 'Seleccione un producto'),
            Forms\Components\Placeholder::make('nuevo_stock')
                ->label('Nuevo Stock')
                ->content(function ($get) {
                    $stockActual = $get('stock_actual');
                    $cantidad = $get('cantidad');
                    if (is_numeric($stockActual) && is_numeric($cantidad)) {
                        return $stockActual + $cantidad;
                    }
                    return 'Pendiente';
                }),
                Forms\Components\Select::make('proveedor_id')
                ->relationship('proveedor', 'nombre')
                ->required(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('detalle_compra')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('producto.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompra::route('/create'),
            'edit' => Pages\EditCompra::route('/{record}/edit'),
        ];
    }
}
