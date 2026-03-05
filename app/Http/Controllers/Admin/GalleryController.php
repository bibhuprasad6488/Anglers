<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = CmsGallery::orderBy('id')->get()->map(function ($g) {
            $g->img_path = $g->img_path ? asset('storage/images/cmspage/' . $g->img_path) : '';
            return $g;
        });
        return view('admin.cmspages.gallerypage', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }
        DB::beginTransaction();

        try {

            $destinationPath = public_path('storage/images/cmspage/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->move($destinationPath, $filename);

                    $gallery = new CmsGallery();
                    $gallery->img_title = $request->img_title ?? null;
                    $gallery->img_path = $filename;
                    $gallery->save();
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Images uploaded successfully'
            ]);
        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Upload failed: ' . $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $g = CmsGallery::find($id);
            if ($g->status == 1) {
                $g->status = '0';
            } else {
                $g->status = '1';
            }
            $g->save();
            return response()->json(['status' => true, 'message' => 'Status chnaged successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => true, 'message' => 'Status chnaged failed Error: ' . $th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $g = CmsGallery::find($id);

            $destinationPath = public_path('storage/images/cmspage/');
            if (!empty($g->img_path)) {
                $oldFilePath = $destinationPath . $g->img_path;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $g->delete();

            return back()->with('success', 'Image deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Page delete failed Error: ' . $th->getMessage());
        }
    }
}
