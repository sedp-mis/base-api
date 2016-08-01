<?php

class Post extends Eloquent
{
    protected $fillable = ['id', 'title'];

    public function comments()
    {
        return $this->hasMany('Comment');
    }
}