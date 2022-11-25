<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessedWebhooks extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
}
