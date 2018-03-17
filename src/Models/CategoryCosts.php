<?php

namespace SONFin\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryCosts extends Model
{
    // Mass Assignment
    protected $fillable = [
        "name",
        "user_id"
    ];
}