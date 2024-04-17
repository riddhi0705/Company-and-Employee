<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'logo', 'website'];

    public function getLogoAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }
        
        // Return a default logo if none is set
        return asset('storage/default-logo.png');
    }

}
