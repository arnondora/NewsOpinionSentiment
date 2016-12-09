<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  protected $table = "Topic";
  public $timestamps = true;

  public function news ()
  {
    return $this->hasMany('TopicNews','TopicID');
  }
}
