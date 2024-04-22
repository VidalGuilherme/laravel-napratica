<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier_id',
        'order',
        'name',
        'company',
        'office',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class, 'contact_id');
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'contact_id');
    }
}
