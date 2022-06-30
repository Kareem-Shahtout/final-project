<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PostCategory::when($request->query('parent_id'), function($query, $value) {
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
        $postCategory = PostCategory::create($request->all());
        $postCategory->refresh();
        return new JsonResponse($postCategory, 201, [
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
        return PostCategory::with('id')->findOrFail($id);
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
        $postCategory = PostCategory::findOrFail($id);
        $postCategory ->update($request->all());
        return Response::json([
            'message' => 'Post Category update',
            'postCategory' => $postCategory,
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
        $postCategory = PostCategory::findOrFail($id);
        $postCategory ->delete();
        return Response::json([
            'message' => 'Post Category deleted',
        ]);
    }
}
