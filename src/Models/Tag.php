<?php

namespace Models;


class Tag extends \Illuminate\Database\Eloquent\Model
{
  public function posts() {
    return $this->belongsToMany(Post::class)->withTimestamps();
  }
}