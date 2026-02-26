<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\PricingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pricings = Pricing::orderBy('id')->with('category')->get();
        return view('admin.pricings.list', compact('pricings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $priceCategories = PricingCategory::where('status', 1)->get();
        return view('admin.pricings.add', compact('priceCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pricing_cat_id' => 'required',
            'pricing_text' => 'required|array',
            'price' => 'required|array',
        ]);
        $debug = [];
        DB::beginTransaction();
        try {
            if (isset($request->pricing_text)) {
                foreach ($request->pricing_text as $k => $pt) {
                    $existing = Pricing::where('pricing_cat_id', $request->pricing_cat_id)
                        ->where('pricing_text', $pt)
                        ->first();
                    $c = $k + 1;
                    if ($existing) {
                        $debug[] = "skipping existing pricing for " . $c . " row";
                        continue;
                    }
                    if ($request->price[$k] === '') {
                        $debug[] = "Skipping empty price for text:" . $request->pricing_title[$k];
                        continue;
                    }
                    $p = new Pricing();
                    $p->pricing_cat_id = $request->pricing_cat_id;
                    $p->pricing_text = $pt;
                    $p->pricing_title = $request->pricing_title[$k];
                    $p->price = $request->price[$k];
                    $p->save();
                }
            }

            // dd($debug);
            DB::commit();
            if (count($debug) > 0) {
                return redirect()->route('admin.pricings.index')->with('error', 'Pricing created with some warnings. ' . implode('; ', $debug));
            }
            return redirect()->route('admin.pricings.index')->with('success', 'Pricing created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pricing creation failed Error: ' . $th->getMessage());
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
        $pricings = Pricing::where('pricing_cat_id', $id)->get();
        $priceCategories = PricingCategory::where('status', 1)->get();
        return view('admin.pricings.edit', compact('priceCategories', 'pricings', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pricing_cat_id' => 'required',
            'pricing_text' => 'required|array',
            'price' => 'required|array',
        ]);

        // dd($request->all());
        $debug = [];
        DB::beginTransaction();
        try {
            if (isset($request->pricing_text)) {
                Pricing::where('pricing_cat_id', $request->pricing_cat_id)->delete();
                foreach ($request->pricing_text as $k => $pt) {
                    if ($request->price[$k] === '') {
                        $debug[] = "Skipping empty price for text:" . $request->pricing_title[$k];
                        continue;
                    }
                    $p = new Pricing();
                    $p->pricing_cat_id = $request->pricing_cat_id;
                    $p->pricing_text = $pt;
                    $p->pricing_title = $request->pricing_title[$k];
                    $p->price = $request->price[$k];
                    $p->save();
                }
            }

            DB::commit();
            if (count($debug) > 0) {
                return redirect()->route('admin.pricings.index')->with('error', 'Pricing updated with some warnings. ' . implode('; ', $debug));
            }
            return redirect()->route('admin.pricings.index')->with('success', 'Pricing updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pricing update failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Pricing::find($id)->delete();
            return redirect()->back()->with('warning', 'Pricing deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Pricing delete failed Error: ' . $th->getMessage());
        }
    }
}
