<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PropertyCategory::orderByDesc('id')->get();
        return view('admin.propertycategories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.propertycategories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pCat = new PropertyCategory();
            $pCat->title = $request->title;
            $pCat->slug = Str::slug(trim($request->title));
            $pCat->description = $request->description;
            $pCat->save();

            DB::commit();
            return redirect()->route('admin.property-categories.index')->with('success', 'Category created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Category creation failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function addProperty($id)
    {
        $pCat = PropertyCategory::find($id);
        return view('admin.propertycategories.addproperty', compact('pCat'));
    }

    public function viewProperties($id)
    {
        $properties = Property::where('category_id', $id)->get();
        return view('admin.propertycategories.viewproperties', compact('properties'));
    }

    public function editProperty($id)
    {
        $property = Property::with('images')->find($id);
        $images = $property->images->map(function ($img) {
            $img->img_path = $img->img_path ? asset('storage/images/property/' . $img->img_path) : '';
            return $img;
        });
        return view('admin.propertycategories.editproperty', compact('property', 'images'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cat = PropertyCategory::find($id);
        return view('admin.propertycategories.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $pCat = PropertyCategory::find($id);
            $pCat->title = $request->title;
            $pCat->slug = Str::slug(trim($request->title));
            $pCat->description = $request->description;
            $pCat->save();

            DB::commit();
            return redirect()->route('admin.property-categories.index')->with('success', 'Category updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Category update failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $destinationPath = public_path('storage/images/property/');
            $cat = PropertyCategory::find($id);
            $properties = Property::where('category_id', $cat->id)->get();
            foreach ($properties as $key => $property) {
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
            }
            $cat->delete();

            return back()->with('success', 'Category Deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to delete category Error: ' . $th->getMessage());
        }
    }
}
