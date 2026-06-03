<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            $b->meta_title = $request->meta_title;
            $b->meta_desc = $request->meta_desc;
            $b->meta_key = $request->meta_key;

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
        try {
            $blog = Blog::find($id);
            if ($blog->status == 1) {
                $blog->status = '0';
            } else {
                $blog->status = '1';
            }
            $blog->save();
            return response()->json(['status' => true, 'message' => 'Status chnaged successfully', 'blog' => $blog]);
        } catch (\Throwable $th) {
            return response()->json(['status' => true, 'message' => 'Status chnaged failed Error: ' . $th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        $blog->blog_img = $blog->blog_img ? asset('storage/images/blog_images/' . $blog->blog_img) : '';
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
            $b->meta_title = $request->meta_title;
            $b->meta_desc = $request->meta_desc;
            $b->meta_key = $request->meta_key;

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
        try {
            $blog = Blog::find($id);

            $destinationPath = public_path('storage/images/blog_images/');
            if (!empty($blog->blog_img)) {
                $oldFilePath = $destinationPath . $blog->blog_img;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $blog->delete();

            return redirect()->back()->with('success', 'Post deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Post delete failed Error: ' . $th->getMessage());
        }
    }

    public function getLiveBlogs()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        $page = 1;
        $allPosts = [];
        $postArr = [];

        do {

            $response = Http::withoutVerifying()
                ->timeout(120)
                ->get(
                    'https://www.anglershideawaycabins.com/wp-json/wp/v2/posts',
                    [
                        'per_page' => 10,
                        'page' => $page,
                        '_fields' => 'id,title,slug,excerpt,content,featured_media,date'
                    ]
                );

            if (!$response->successful()) {
                break;
            }

            $posts = $response->json();

            $allPosts = array_merge($allPosts, $posts);

            $page++;
        } while (!empty($posts));

        //     /*
        // |--------------------------------------------------------------------------
        // | Fetch all media separately
        // |--------------------------------------------------------------------------
        // */

        $mediaMap = [];

        $mediaPage = 1;

        do {

            $mediaResponse = Http::withoutVerifying()
                ->timeout(120)
                ->get(
                    'https://www.anglershideawaycabins.com/wp-json/wp/v2/media',
                    [
                        'per_page' => 10,
                        'page' => $mediaPage,
                        '_fields' => 'id,title,slug,excerpt,content,featured_media,date'
                    ]
                );

            if (!$mediaResponse->successful()) {
                break;
            }

            $mediaItems = $mediaResponse->json();

            foreach ($mediaItems as $media) {
                $mediaMap[$media['id']] = $media['source_url'] ?? '';
            }

            $mediaPage++;
        } while (!empty($mediaItems));

        //     /*
        // |--------------------------------------------------------------------------
        // | Prepare posts data
        // |--------------------------------------------------------------------------
        // */

        foreach ($allPosts as $post) {

            $featuredImage = '';

            if (!empty($post['featured_media'])) {
                $featuredImage = $mediaMap[$post['featured_media']] ?? '';
            }

            $postArr[] = [
                'wp_post_id'     => $post['id'],
                'title'          => html_entity_decode($post['title']['rendered'] ?? ''),
                'slug'           => $post['slug'] ?? '',
                'content'        => $post['content']['rendered'] ?? '',
                'short_content'  => trim(strip_tags($post['excerpt']['rendered'] ?? '')),
                'featured_image' => $featuredImage,
                'published_at'   => $post['date'] ?? '',
            ];
        }

        // dd($postArr);
        //     /*
        // |--------------------------------------------------------------------------
        // | Save blogs
        // |--------------------------------------------------------------------------
        // */

        foreach ($postArr as $post) {

            $checkExisting = Blog::where('title', $post['title'])->first();

            if (!$checkExisting) {

                $blog = new Blog();
                $blog->title = $post['title'];
                $blog->slug = Str::slug(trim($post['title']));
                $blog->short_desc = $post['short_content'];
                $blog->added_by = 1;
                $blog->long_desc = $post['content'];
                $blog->meta_title = $post['title'];
                $blog->meta_desc = $post['short_content'];
                $blog->meta_key = '';

                // // Download featured image
                if (!empty($post['featured_image'])) {

                    try {

                        $destinationPath = public_path('storage/images/blog_images/');

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }

                        $extension = pathinfo(
                            parse_url($post['featured_image'], PHP_URL_PATH),
                            PATHINFO_EXTENSION
                        );

                        $extension = !empty($extension) ? $extension : 'jpg';

                        $fileName = time() . '_' . uniqid() . '.' . $extension;

                        $fullPath = $destinationPath . $fileName;

                        $imageResponse = Http::withoutVerifying()
                            ->timeout(60)
                            ->get($post['featured_image']);

                        if ($imageResponse->successful()) {

                            file_put_contents(
                                $fullPath,
                                $imageResponse->body()
                            );

                            $blog->blog_img = $fileName;
                        }
                    } catch (\Exception $e) {

                        Log::error(
                            'Blog image download failed: ' .
                                $post['featured_image'] .
                                ' | Error: ' .
                                $e->getMessage()
                        );
                    }
                }

                $blog->save();
            }
        }

        return response()->json([
            'status' => true,
            'total_posts' => count($postArr),
            'imported' => Blog::count()
        ]);
    }
}
