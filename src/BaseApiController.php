<?php

namespace SedpMis\BaseApi;

use SedpMis\Lib\IlluminateExtensions\Input;
use Illuminate\Http\Response;

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
        return new Response($this->repo->create(Input::all()), 201);
    }

    public function update($id)
    {
        return new Response($this->repo->update(Input::all(), $id), 202);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return new Response('Successfully Deleted!', 202);
    }
}
