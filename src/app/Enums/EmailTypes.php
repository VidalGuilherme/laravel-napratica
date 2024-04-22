<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum EmailTypes : string
{
    case PESSOAL = 'personal';
    case COMERCIAL = 'commercial';
    case OUTRO = 'other';

    public static function getOptions() : Collection
    {
        return collect(self::cases())->mapWithKeys(function ($o) {            
            return [$o->value => $o->title()];
        });
    }
    
    public function title(): string {
        return match ($this) {
            EmailTypes::PESSOAL => 'Pessoal',
            EmailTypes::COMERCIAL => 'Comercial',
            EmailTypes::OUTRO => 'Outro',
        };
    }
}
