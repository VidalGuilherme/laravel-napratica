<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum SupplierTypes : string
{
    case PJ = 'pj';
    case PF = 'pf';

    public static function getOptions() : Collection
    {
        return collect(self::cases())->mapWithKeys(function ($o) {            
            return [$o->value => $o->title()];
        });
    }
    
    public function title(): string {
        return match ($this) {
            SupplierTypes::PJ => 'Pessoa Jurídica',
            SupplierTypes::PF => 'Pessoa Física',
        };
    }
}
