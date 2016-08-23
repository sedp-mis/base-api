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
        $pagelo = new PageLimitOffset(Input::get('per_page'), Input::get('page'));

        return $this->repo->with(Input::get('relations', []))->fetch(
            Input::get('attributes', ['*']),
            Input::get('filters', []),
            Input::get('sort', []),
            $pagelo->limit(),
            $pagelo->offset()
        );
    }

    public function show($id)
    {
        return $this->repo->with(Input::get('relations', []))->findOrFail($id, Input::get('attributes', ['*']));
    }

    public function store()
    {
        return new Response($this->repo->create(Input::all()), 201);
    }

    public function update($id)
    {
        $this->repo->update(Input::all(), $id);
        return new Response('', 204);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return new Response('', 204);
    }
}
