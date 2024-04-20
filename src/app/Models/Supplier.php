<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cpf',
        'personal_name',
        'nickname',
        'rg',            
        'cnpj',
        'company_name',
        'fantasy_name',
        'state_indicator',
        'state_registration',
        'municipal_registration',
        'cnpj_status',
        'retreat',
        'status'
    ];
}
