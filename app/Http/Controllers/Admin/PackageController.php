<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = PricePackage::orderBy('id')->get();
        return view('admin.packages.list', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'cat_id' => 'required',
            'package_text' => 'required|array',
            'price' => 'required|array',
        ]);
        $debug = [];
        DB::beginTransaction();
        try {
            if (isset($request->package_text)) {
                foreach ($request->package_text as $k => $pt) {
                    $existing = PricePackage::where('package_text', $pt)
                        ->first();
                    $c = $k + 1;
                    if ($existing) {
                        $debug[] = "skipping existing package for " . $c . " row";
                        continue;
                    }
                    if ($request->price[$k] === '') {
                        $debug[] = "Skipping empty price for text:" . $request->package_title[$k];
                        continue;
                    }
                    $p = new PricePackage();
                    $p->cat_id = $request->cat_id;
                    $p->package_title = $request->package_title[$k];
                    $p->package_text = $pt;
                    $p->price = $request->price[$k];
                    $p->save();
                }
            }

            DB::commit();
            if (count($debug) > 0) {
                return redirect()->route('admin.packages.index')->with('error', 'Package created with some warnings. ' . implode('; ', $debug));
            }
            return redirect()->route('admin.packages.index')->with('success', 'Package created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Package creation failed Error: ' . $th->getMessage());
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
        $package = PricePackage::find($id);
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // 'cat_id' => 'required',
            'package_text' => 'required',
            'price' => 'required',
        ]);

        // dd($request->all());
        DB::beginTransaction();
        try {
            $p =  PricePackage::find($id);
            // $p->cat_id = $request->package_cat_id;
            $p->package_text = $request->package_text;
            $p->package_title = $request->package_title;
            $p->price = $request->price;
            $p->save();

            DB::commit();
            return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Package update failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            PricePackage::find($id)->delete();
            return redirect()->back()->with('warning', 'Package deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Package delete failed Error: ' . $th->getMessage());
        }
    }
}
