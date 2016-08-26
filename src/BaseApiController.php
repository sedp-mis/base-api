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
        $pagelo = new PageLimitOffset(
            Input::get('per_page', Config::get('sedpmis_base_api.per_page', 15)),
            Input::get('page')
        );

        $this->repo->with(Input::get('relations', []))
            ->attributes(Input::get('attributes', ['*']))
            ->filters(Input::get('filters', []))
            ->sort(Input::get('sort', []))
            ->limit($pagelo->limit())
            ->offset($pagelo->offset());

        if (Input::has('search') && array_key_exists('text', $search = Input::get('search'))) {
            return $this->repo->search($search['text'], array_key_exists('compare', $search) ? $search['compare'] : null);
        }

        return $this->repo->get();
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
        $this->repo->delete($this->repo->findOrFail($id));

        return new Response('', 204);
    }
}
