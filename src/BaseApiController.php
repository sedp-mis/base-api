<?php

namespace SedpMis\BaseApi;

use SedpMis\Lib\IlluminateExtensions\Input;

class BaseApiController extends \Illuminate\Routing\Controller
{

    /**
    * @var \SedpMis\BaseRepository\RepositoryInterface
    */
    protected $repo;

    public function index()
    {
        $attributes = Input::get("attributes");

        $attributes = !empty($attributes) ? $attributes : ['*'];


        $relations = Input::get("relations");

        $relations = !empty($relations) ? $relations : [];

        return $this->repo->with($relations)->fetch($attributes);
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