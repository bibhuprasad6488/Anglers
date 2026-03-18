<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            $existingP = Property::where('title', $request->title)->first();
            if ($existingP) {
                return response()->json(['status' => false, 'message' => 'Property name already exists']);
            }
            $property = new Property();
            $property->title = $request->title;
            $property->category_id = $request->category_id;
            $property->price_per_night = $request->price_per_night;
            $property->price_per_week = $request->price_per_week;
            $property->price_per_month = $request->price_per_month;
            $property->slug = Str::slug(trim($request->title));
            $property->sub_title = $request->sub_title;
            $property->short_desc = $request->short_desc;
            $property->long_desc = $request->long_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->long_desc) : '';
            $property->meta_title = $request->meta_title;
            $property->meta_desc = $request->meta_desc;
            $property->meta_key = $request->meta_key;

            $property->save();

            $destinationPath = public_path('storage/images/property/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->move($destinationPath, $filename);

                    $gallery = new PropertyImage();
                    $gallery->property_id = $property->id;
                    $gallery->img_title = $property->title ?? null;
                    $gallery->img_path = $filename;
                    $gallery->save();
                }
            }


            DB::commit();
            return response()->json(['status' => true, 'message' => 'Property added successfully', 'data' => $request->all()]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Failed to add property Error: ' . $th->getMessage()]);
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
        $property = Property::find($id);
        $images = PropertyImage::where('property_id', $id)->get()->map(function ($img) {
            $img->img_path = $img->img_path ? asset('storage/images/property/' . $img->img_path) : '';
            return $img;
        });
        return view('admin.property.edit', compact('property', 'images'));
    }

    public function deletePropertyImage($id)
    {
        try {
            $destinationPath = public_path('storage/images/property/');
            $img = PropertyImage::find($id);
            if (!empty($img->img_path)) {
                $oldFilePath = $destinationPath . $img->img_path;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $img->delete();
            return response()->json(['status' => true, 'message' => 'Image deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Failed to delete image Error: ' . $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $existingP = Property::where('title', $request->title)->where('id', '!=', $id)->first();
            if ($existingP) {
                return response()->json(['status' => false, 'message' => 'Property name already exists']);
            }
            $property = Property::find($id);
            $property->title = $request->title;
            $property->slug = Str::slug(trim($request->title));
            $property->category_id = $request->category_id;
            $property->price_per_night = $request->price_per_night;
            $property->price_per_week = $request->price_per_week;
            $property->price_per_month = $request->price_per_month;
            $property->sub_title = $request->sub_title;
            $property->short_desc = $request->short_desc;
            $property->long_desc = $request->long_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->long_desc) : '';
            $property->meta_title = $request->meta_title;
            $property->meta_desc = $request->meta_desc;
            $property->meta_key = $request->meta_key;

            $property->save();

            $destinationPath = public_path('storage/images/property/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('images')) {

                // $images = PropertyImage::where('property_id', $id)->get();
                // foreach ($images as $img) {
                //     if (!empty($img->img_path)) {
                //         $oldFilePath = $destinationPath . $img->img_path;
                //         if (file_exists($oldFilePath)) {
                //             unlink($oldFilePath);
                //         }
                //     }
                //     $img->delete();
                // }

                foreach ($request->file('images') as $image) {

                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->move($destinationPath, $filename);

                    $gallery = new PropertyImage();
                    $gallery->property_id = $property->id;
                    $gallery->img_title = $property->title ?? null;
                    $gallery->img_path = $filename;
                    $gallery->save();
                }
            }


            DB::commit();
            return response()->json(['status' => true, 'message' => 'Property updated successfully']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Failed to update property Error: ' . $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $destinationPath = public_path('storage/images/property/');

            $property = Property::find($id);
            $pImg = PropertyImage::where('property_id', $id)->get();
            foreach ($pImg as $img) {
                if (!empty($img->img_path)) {
                    $oldFilePath = $destinationPath . $img->img_path;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $img->delete();
            }
            $property->delete();

            return back()->with('success', 'Property Deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to delete property Error: ' . $th->getMessage());
        }
    }
}
