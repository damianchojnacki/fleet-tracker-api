<?php

namespace App\Enums;

enum CarOperationType: string
{
    use StringEnumHelpers;

    case REFUELING = 'refueling';
    case MAINTENANCE = 'maintenance';
    case REPAIR = 'repair';
    case OTHER = 'other';

    public function getName(): string
    {
        return match ($this) {
            self::REFUELING => __('Refueling'),
            self::MAINTENANCE => __('Maintenance'),
            self::REPAIR => __('Repair'),
            self::OTHER => __('Other'),
        };
    }
}
