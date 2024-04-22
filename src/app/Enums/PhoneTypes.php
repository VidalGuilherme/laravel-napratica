<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum PhoneTypes : string
{    
    case RESIDENCIAL = 'residential';
    case COMERCIAL = 'commercial';
    case CELULAR = 'cellphone';

    public static function getOptions() : Collection
    {
        return collect(self::cases())->mapWithKeys(function ($o) {            
            return [$o->value => $o->title()];
        });
    }
    
    public function title(): string {
        return match ($this) {
            PhoneTypes::RESIDENCIAL => 'Residencial',
            PhoneTypes::COMERCIAL => 'Comercial',
            PhoneTypes::CELULAR => 'Celular',
        };
    }
}
