<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::get();
        if ($request->ajax()) {
            $allData = Datatables::of($posts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href = "javascript:void(0)" data-toggle="tooltip" data-id ="' . $row->id . '" data-original-title = "Edit" class="edit btn btn-primary btn-sm editPost">Edit</a> &nbsp';
                    $btn .= '<a href = "javascript:void(0)" data-toggle="tooltip" data-id ="' . $row->id . '" data-original-title = "Delete" class="edit btn btn-danger btn-sm deletePost"> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.index', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);

        Post::updateOrCreate([
            ['id' => $request->id],
            [
                'title' => $request->title,
                'description' => $request->description
            ],
        ]);
        return response()->json(['success' => 'Post added successfully']);
        return redirect()->route('Posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::findorfail($id);
        return response()->json($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json(['success' => 'Post Deleted Successfully']);
    }
}
