<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicNews extends Model
{
  protected $table = "NewsPublisher";
  public $timestamps = false;

  public function news ()
  {
    return $this->belognsTo('News');
  }

  public function topic ()
  {
    return $this->belognsTo('Topic');
  }
}
