<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  protected $table = "News";
  public $timestamps = true;

  public function publisher ()
  {
    return $this->hasOne('NewsPublisher');
  }

  public function topics ()
  {
    return $this->hasMany('TopicNews','NewsID');
  }
}
