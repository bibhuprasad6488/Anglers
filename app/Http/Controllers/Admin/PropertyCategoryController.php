<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
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
        //
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
            return back()->with('success', 'Category created successfully');
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
