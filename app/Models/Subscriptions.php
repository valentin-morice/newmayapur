<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    /**
     * @mixin Builder
     */
    use HasFactory;

    protected $guarded = [];

    public function members()
    {
        return $this->belongsTo(Members::class);
    }
}
