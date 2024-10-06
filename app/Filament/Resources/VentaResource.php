<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Models\Venta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('detalle_venta')
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
                            return max(0, $stockActual - $cantidad);
                        }
                        return 'Pendiente';
                    }),
                    Forms\Components\Select::make('cliente_id')
                    ->relationship('cliente', 'nombre')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('detalle_venta')
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
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->numeric()
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
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
