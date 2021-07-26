<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Contact extends Model
{   
    use Sluggable;
    use HasFactory;
    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'first_name'
            ]
        ];
    }

    // city
    public function cityname(){
        return $this->HasOne('App\Models\City','id','city');
    }
}
