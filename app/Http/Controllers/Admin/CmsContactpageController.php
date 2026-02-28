<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsContactPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CmsContactpageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactPage = CmsContactPage::find(1);
        return view('admin.cmspages.contactpage', compact('contactPage'));
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
            $contactPage = CmsContactPage::find(1) ?? new CmsContactPage();
            $contactPage->title = $request->title;
            $contactPage->meta_title = $request->meta_title;
            $contactPage->meta_desc = $request->meta_desc;
            $contactPage->meta_key = $request->meta_key;
            $contactPage->save();
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
