<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPublisher extends Model
{
    protected $table = "NewsPublisher";
    public $timestamps = false;

    public function news ()
    {
      return $this->hasMany('News');
    }
}
