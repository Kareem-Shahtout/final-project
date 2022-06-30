<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class PostTagCntroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PostTag::when($request->query('parent_id'), function($query, $value) {
            $query->where('parent_id', '=', $value);
        })
        ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posttag = PostTag::create($request->all());
        $posttag->refresh();
        return new JsonResponse($posttag, 201, [
            'x-application-name' => config('app.name'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PostTag::with('id')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $posttag = PostTag::findOrFail($id);
        $posttag ->update($request->all());
        return Response::json([
            'message' => 'Post Tag update',
            'posttag' => $posttag,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posttag = PostTag::findOrFail($id);
        $posttag ->delete();
        return Response::json([
            'message' => 'Post Tag deleted',
        ]);
    }
}
