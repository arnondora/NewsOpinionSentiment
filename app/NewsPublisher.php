<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPublisher extends Model
{
    protected $table = "NewsPublisher";
    public $timestamp = false;

    public function news ()
    {
      return $this->hasMany('News');
    }
}
