<?php

namespace App\Models;

use Database\Factories\UrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UrlFactory::new();
    }

    protected $fillable = ['original_url', 'short_code'];
}