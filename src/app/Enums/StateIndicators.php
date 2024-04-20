<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum StateIndicators : string
{
    case CONTRIBUINTE = 'contribuinte';
    case CONTRIBUINTE_INSENTO = 'contribuinte_insento';
    case NAO_CONTRIBUINTE = 'nao_contribuinte';    

    public static function getOptions() : Collection
    {
        return collect(self::cases())->mapWithKeys(function ($o) {            
            return [$o->value => $o->title()];
        });
    }

    public function title(): string 
    {
        return match ($this) {
            StateIndicators::CONTRIBUINTE => 'Contribuinte',
            StateIndicators::CONTRIBUINTE_INSENTO => 'Contribuinte Insento',
            StateIndicators::NAO_CONTRIBUINTE => 'Não Contribuinte',
        };
    }
}
