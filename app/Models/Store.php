<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        "user_id",
        "name",
        "description",
        "city",
        "phone",
        "link1",
        "link2",
        "link3",
        "avatar_url",
        "background_url",
    ]
}
