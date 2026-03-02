<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderByDesc('id')->get()->map(function ($b) {
            $b->blog_img = $b->blog_img ? asset('storage/images/blog_images/' . $b->blog_img) : '';
            return $b;
        });
        return view('admin.posts.list', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $b = new Blog();
            $b->title = $request->title;
            $b->slug = Str::slug(trim($request->title));
            $b->short_desc = $request->short_desc;
            $b->added_by = Auth::user()->id;
            $b->long_desc = $request->long_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->long_desc) : '';

            // /** Upload Path */
            $destinationPath = public_path('storage/images/blog_images/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Banner Image
            if ($request->hasFile('blog_img')) {
                $file = $request->file('blog_img');
                $bannerImg = 'blog_img_' . Str::slug(trim($request->title)) . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $bannerImg);
                $b->blog_img = $bannerImg;
            }

            $b->save();
            DB::commit();

            return redirect()->route('admin.posts.index')->with('success', 'Post Added successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Post add failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('admin.posts.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $b =  Blog::find($id);
            $b->title = $request->title;
            $b->slug = Str::slug(trim($request->title));
            $b->short_desc = $request->short_desc;
            $b->added_by = Auth::user()->id;
            $b->long_desc = $request->long_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->long_desc) : '';

            // /** Upload Path */
            $destinationPath = public_path('storage/images/blog_images/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Banner Image
            if ($request->hasFile('blog_img')) {
                $file = $request->file('blog_img');
                $bannerImg = 'blog_img_' . Str::slug(trim($request->title)) . '_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($b->blog_img)) {
                    $oldFilePath = $destinationPath . $b->blog_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $bannerImg);

                $b->blog_img = $bannerImg;
            }

            $b->save();
            DB::commit();

            return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Post update failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
