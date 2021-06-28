<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $with = ['layouts'];

    protected $fillable = [
      'name', 'code'
    ];

    public function layouts()
    {
        return $this->hasMany(Layout::class);
    }
}
