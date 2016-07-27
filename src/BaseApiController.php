<?php

namespace SedpMis\BaseApi;

class BaseApiController extends \Illuminate\Routing\Controller
{

  /**
   * @var \SedpMis\BaseRepository\RepositoryInterface
   */
  protected $repo;

  public function index()
  {
    return $this->repo->all();
  }

  public function show($id)
  {
    return $this->repo->find($id);
  }

  public function store()
  {
    return $this->repo->create();
  }

  public function update($id)
  {
    return $this->repo->update($id);
  }

  public function destroy($id)
  {
    return $this->repo->delete($id);
  }
  
}