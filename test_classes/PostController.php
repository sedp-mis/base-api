<?php

class PostController extends \SedpMis\BaseApi\BaseApiController
{
  public function __construct(PostRepositoryEloquent $repo)
  {
    $this->repo = $repo;
  }
}