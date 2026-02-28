<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsHomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homePage = CmsHomePage::find(1);
        if ($homePage) {
            $homePage->banner_img = $homePage->banner_img ? asset('storage/images/cmspage/' . $homePage->banner_img) : '';
            $homePage->setion_one_img = $homePage->setion_one_img ? asset('storage/images/cmspage/' . $homePage->setion_one_img) : '';
            $homePage->setion_two_img = $homePage->setion_two_img ? asset('storage/images/cmspage/' . $homePage->setion_two_img) : '';
        }
        return view('admin.cmspages.homepage', compact('homePage'));
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
            $homePage = CmsHomePage::find(1) ?? new CmsHomePage();
            $homePage->banner_title = $request->banner_title;
            $homePage->banner_sub_title = $request->banner_sub_title;
            $homePage->setion_one_title = $request->setion_one_title;
            $homePage->setion_one_desc = $request->setion_one_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->setion_one_desc) : '';
            $homePage->setion_one_btn_text = $request->setion_one_btn_text;
            $homePage->setion_one_btn_link = $request->setion_one_btn_link;
            $homePage->setion_two_title = $request->setion_two_title;
            $homePage->setion_two_desc = $request->setion_two_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->setion_two_desc) : '';
            $homePage->meta_title = $request->meta_title;
            $homePage->meta_desc = $request->meta_desc;
            $homePage->meta_key = $request->meta_key;


            // /** Upload Path */
            $destinationPath = public_path('storage/images/cmspage/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Banner Image
            if ($request->hasFile('banner_img')) {
                $file = $request->file('banner_img');
                $bannerImg = 'banner_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($homePage->banner_img)) {
                    $oldFilePath = $destinationPath . $homePage->banner_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $bannerImg);

                $homePage->banner_img = $bannerImg;
            }

            // Setion One Image
            if ($request->hasFile('setion_one_img')) {
                $file = $request->file('setion_one_img');
                $sOneImg = 'sect_one_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($homePage->setion_one_img)) {
                    $oldFilePath = $destinationPath . $homePage->setion_one_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $sOneImg);

                $homePage->setion_one_img = $sOneImg;
            }

            // Setion One Image
            if ($request->hasFile('setion_two_img')) {
                $file = $request->file('setion_two_img');
                $sOneImg = 'sect_two_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($homePage->setion_two_img)) {
                    $oldFilePath = $destinationPath . $homePage->setion_two_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $sOneImg);

                $homePage->setion_two_img = $sOneImg;
            }

            $homePage->save();
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
