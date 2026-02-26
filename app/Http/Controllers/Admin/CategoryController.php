<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\PricingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceCategories = PricingCategory::orderByDesc('id')->get();
        return view('admin.price_category.list', compact('priceCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.price_category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->name) {
            return redirect()->back()->with('error', 'Name is required');
        }

        $existingCat = PricingCategory::where('name', $request->name)->first();
        if ($existingCat) {
            return redirect()->back()->with('error', 'Category already existing');
        }

        DB::beginTransaction();
        try {
            $pc = new PricingCategory();
            $pc->name = $request->name;
            $pc->slug = Str::slug($request->name);
            $pc->desctiption = $request->desctiption;
            $pc->save();
            DB::commit();
            return redirect()->back()->with('success', 'Category created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Category creation failed Error: ' . $th->getMessage());
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
        $pc = PricingCategory::find($id);
        return view('admin.price_category.edit', compact('pc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$request->name) {
            return redirect()->back()->with('error', 'Name is required');
        }

        $existingCat = PricingCategory::where('name', $request->name)->where('id', '!=', $id)->first();
        if ($existingCat) {
            return redirect()->back()->with('error', 'Category already existing');
        }

        DB::beginTransaction();
        try {
            $pc =  PricingCategory::find($id);
            $pc->name = $request->name;
            $pc->desctiption = $request->desctiption;
            $pc->slug = Str::slug($request->name);
            $pc->save();
            DB::commit();
            return redirect()->route('admin.price-categories.index')->with('success', 'Category updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Category update failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pc = PricingCategory::find($id);
            Pricing::where('pricing_cat_id', $pc->id)->delete();
            $pc->delete();
            return redirect()->back()->with('error', 'Category deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
}
