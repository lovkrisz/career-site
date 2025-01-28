<?php

namespace App\Domain\Career\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
	protected $fillable = [
		'name',
	];


    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}
