<?php

namespace App\Filament\Exports;

use App\Models\Car;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CarExporter extends Exporter
{
    protected static ?string $model = Car::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('brand.name'),
            ExportColumn::make('plate_number'),
            ExportColumn::make('vin'),
            ExportColumn::make('mileage'),
            ExportColumn::make('color'),
            ExportColumn::make('is_active'),
            ExportColumn::make('specs'),
            ExportColumn::make('created_at'),
        ];
    }

    public function getFormats(): array
    {
        return [
            ExportFormat::Xlsx,
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your car export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
