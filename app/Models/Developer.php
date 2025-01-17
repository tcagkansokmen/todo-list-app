<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Developer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'capacity', 'weekly_hours'];

    /**
     * Get the tasks for the developer.
     *
     * @return HasMany
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
