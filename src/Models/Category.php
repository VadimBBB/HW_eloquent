<?php

namespace Models;


class Category extends \Illuminate\Database\Eloquent\Model
{
  public function posts() {
    return $this->hasMany(Post::class);
  }
}