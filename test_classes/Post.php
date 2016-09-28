<?php

use SedpMis\BaseRepository\ValidatingTrait;

class Post extends Eloquent
{
    use  ValidatingTrait;

    protected $fillable = ['id', 'title'];

    public function comments()
    {
        return $this->hasMany('Comment');
    }
}