<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier_type',
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
        'active',
        'note',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'supplier_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'supplier_id');
    }
}
