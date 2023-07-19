<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    public $table = 'version';

    protected $fillable = [
        'version_name',
        'version_code',
        'is_active',
    ];
}
