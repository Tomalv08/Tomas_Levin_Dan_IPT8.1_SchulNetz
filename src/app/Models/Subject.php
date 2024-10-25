<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Subject.php
    protected $fillable = ['name', 'type']; // 'type' kann 'I' für Informatik oder andere Kategorien haben

    use HasFactory;

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
