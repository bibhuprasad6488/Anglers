<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resource = CmsResource::find(1);
        if ($resource) {
            $resource->banner_img = $resource->banner_img ? asset('storage/images/cmspage/' . $resource->banner_img) : '';
            $resource->setion_one_img = $resource->setion_one_img ? asset('storage/images/cmspage/' . $resource->setion_one_img) : '';
            $resource->setion_two_img = $resource->setion_two_img ? asset('storage/images/cmspage/' . $resource->setion_two_img) : '';
        }
        return view('admin.cmspages.resources', compact('resource'));
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
        DB::beginTransaction();
        try {
            $resource = CmsResource::find(1) ?? new CmsResource();
            $resource->title = $request->title;
            $resource->setion_one_title = $request->setion_one_title;
            $resource->setion_one_desc = $request->setion_one_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->setion_one_desc) : '';
            $resource->setion_two_title = $request->setion_two_title;
            $resource->setion_two_desc = $request->setion_two_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->setion_two_desc) : '';
            $resource->resource_title = $request->resource_title;
            $resource->resource_desc = $request->resource_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->resource_desc) : '';
            $resource->resource_btn_one_text = $request->resource_btn_one_text;
            $resource->resource_btn_one_link = $request->resource_btn_one_link;
            $resource->resource_btn_two_text = $request->resource_btn_two_text;
            $resource->resource_btn_two_link = $request->resource_btn_two_link;
            $resource->resource_btn_three_text = $request->resource_btn_three_text;
            $resource->resource_btn_three_link = $request->resource_btn_three_link;
            $resource->meta_title = $request->meta_title;
            $resource->meta_desc = $request->meta_desc;
            $resource->meta_key = $request->meta_key;


            // /** Upload Path */
            $destinationPath = public_path('storage/images/cmspage/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }


            // Setion One Image
            if ($request->hasFile('setion_one_img')) {
                $file = $request->file('setion_one_img');
                $sOneImg = 'sect_one_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($resource->setion_one_img)) {
                    $oldFilePath = $destinationPath . $resource->setion_one_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $sOneImg);

                $resource->setion_one_img = $sOneImg;
            }

            // Setion One Image
            if ($request->hasFile('setion_two_img')) {
                $file = $request->file('setion_two_img');
                $sOneImg = 'sect_two_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($resource->setion_two_img)) {
                    $oldFilePath = $destinationPath . $resource->setion_two_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $sOneImg);

                $resource->setion_two_img = $sOneImg;
            }
            $resource->save();
            DB::commit();

            return back()->with('success', 'Page updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Page update failed Error: ' . $th->getMessage());
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
        //
    }
}
