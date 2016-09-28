<?php

class PostRepositoryEloquent extends \SedpMis\BaseRepository\BaseRepositoryEloquent implements \SedpMis\BaseRepository\RepositoryInterface
{
  public function __construct(Post $model)
  {
    $this->model = $model;
  }
}