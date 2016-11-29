<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  protected $table = "Topic";
  public $timestamp = true;

  public function news ()
  {
    return $this->hasMany('TopicNews','TopicID');
  }
}
