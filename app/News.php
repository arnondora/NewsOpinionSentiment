<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  protected $table = "News";
  public $timestamps = true;

  public function publisher ()
  {
    return $this->belongsTo(NewsPublisher::class,'NewsPublisher','id');
  }
}
