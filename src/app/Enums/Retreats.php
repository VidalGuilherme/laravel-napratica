<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Retreats : string
{
    case RECOLHER = 'recolher';
    case RETIDO = 'retido';

    public static function getOptions() : Collection
    {
        return collect(self::cases())->mapWithKeys(function ($o) {            
            return [$o->value => $o->title()];
        });
    }
    
    public function title(): string {
        return match ($this) {
            Retreats::RECOLHER => 'A Recolher pelo Prestador',
            Retreats::RETIDO => 'Retido pelo Tomador',
        };
    }
}
