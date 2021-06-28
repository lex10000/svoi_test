<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
      'layout_filename', 'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
