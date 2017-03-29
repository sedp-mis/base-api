<?php

namespace SedpMis\BaseApi;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class BaseApiController extends \Illuminate\Routing\Controller
{
    /**
     * @var \SedpMis\BaseRepository\RepositoryInterface
     */
    protected $repo;

    /**
     * Display a listing of the resource.
     * GET /<resource>.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repo->applyQueryParams(app('request'))->get();
    }

    /**
     * Display the specified resource.
     * GET /<resource>/{id}.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repo->with(Input::get('relations', []))->findOrFail($id, Input::get('attributes', ['*']));
    }

    /**
     * Store a newly created resource in storage.
     * POST /<resource>.
     *
     * @return Response
     */
    public function store()
    {
        return new Response($this->repo->create(Input::except('_token')), 201);
    }

    /**
     * Update the specified resource in storage.
     * PUT /<resource>/{id}.
     *
     * @param  int      $id
     * @return Response
     */
    public function update($id)
    {
        $this->repo->update($id, Input::except('_token'));

        return new Response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /<resource>/{id}.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->repo->delete($this->repo->findOrFail($id));

        return new Response('', 204);
    }
}
