<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::orderByDesc('id')->get()->map(function ($p) {
            // $p->logo_path = isset($p->logo_path) ? Storage::disk('public')->url('images/partners/' . $p->logo_path) : '';
            $p->logo_path = isset($p->logo_path) ? asset('storage/images/partners/' . $p->logo_path) : '';

            return $p;
        });
        $setting = \App\Models\SiteSetting::find(1);
        return view('admin.partners.list', compact('partners', 'setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partners.add');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name',
            'logo_path' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp',
            'website_url' => 'nullable|max:255',
            'desc' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $partner = new Partner();
            $partner->name = $request->name;
            $partner->website_url = $request->website_url ?? null;
            $partner->desc = $request->desc ?? null;

            // /** Upload Path */
            $destinationPath = public_path('storage/images/partners/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('logo_path')) {
                $file = $request->file('logo_path');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                /** If already WebP → move directly */
                if ($extension === 'webp') {
                    $file->move($destinationPath, $imageName);
                } else {
                    /** Convert to WebP */
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                            $image = imagecreatefromjpeg($file->getRealPath());
                            break;

                        case 'png':
                            $image = imagecreatefrompng($file->getRealPath());
                            imagepalettetotruecolor($image);
                            imagealphablending($image, true);
                            imagesavealpha($image, true);
                            break;

                        default:
                            throw new \Exception('Unsupported image format');
                    }

                    imagewebp($image, $fullPath, 80);
                    imagedestroy($image);
                }

                $partner->logo_path = $imageName;
            }

            // if ($request->hasFile('logo_path')) {

            //     $file = $request->file('logo_path');

            //     $fileName = preg_replace('/\s+/', '_', Str::slug($request->name))
            //         . '_' . time()
            //         . '.' . $file->getClientOriginalExtension();

            //     // Delete old image if exists
            //     if (
            //         !empty($partner->logo_path) &&
            //         Storage::disk('public')->exists('images/partners/' . $partner->logo_path)
            //     ) {

            //         Storage::disk('public')->delete('images/partners/' . $partner->logo_path);
            //     }

            //     // ✅ Correct usage
            //     Storage::disk('public')->putFileAs(
            //         'images/partners',
            //         $file,
            //         $fileName
            //     );

            //     $partner->logo_path = $fileName;
            // }


            $partner->save();
            DB::commit();

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(
                'error',
                'An error occurred while creating the partner: ' . $th->getMessage()
            );
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
        $partner = Partner::findOrFail($id);
        // $partner->logo_path = isset($partner->logo_path) ? Storage::disk('public')->url('images/partners/' . $partner->logo_path) : '';
        $partner->logo_path = isset($partner->logo_path) ? asset('storage/images/partners/' . $partner->logo_path) : '';

        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name,' . $id,
            'logo_path' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'website_url' => 'nullable|max:255',
            'desc' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $partner = Partner::find($id);
            $partner->name = $request->name;
            $partner->website_url = $request->website_url ?? null;
            $partner->desc = $request->desc ?? null;

            // /** Upload Path */
            $destinationPath = public_path('storage/images/partners/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('logo_path')) {
                $file = $request->file('logo_path');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($partner->logo_path)) {
                    $oldFilePath = $destinationPath . $partner->logo_path;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                /** If already WebP → move directly */
                if ($extension === 'webp') {
                    $file->move($destinationPath, $imageName);
                } else {
                    /** Convert to WebP */
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                            $image = imagecreatefromjpeg($file->getRealPath());
                            break;

                        case 'png':
                            $image = imagecreatefrompng($file->getRealPath());
                            imagepalettetotruecolor($image);
                            imagealphablending($image, true);
                            imagesavealpha($image, true);
                            break;

                        default:
                            throw new \Exception('Unsupported image format');
                    }

                    imagewebp($image, $fullPath, 80);
                    imagedestroy($image);
                }

                $partner->logo_path = $imageName;
            }

            // if ($request->hasFile('logo_path')) {

            //     $file = $request->file('logo_path');

            //     $fileName = preg_replace('/\s+/', '_', Str::slug($request->name))
            //         . '_' . time()
            //         . '.' . $file->getClientOriginalExtension();

            //     // Delete old image if exists
            //     if (
            //         !empty($partner->logo_path) &&
            //         Storage::disk('public')->exists('images/partners/' . $partner->logo_path)
            //     ) {

            //         Storage::disk('public')->delete('images/partners/' . $partner->logo_path);
            //     }

            //     // ✅ Correct usage
            //     Storage::disk('public')->putFileAs(
            //         'images/partners',
            //         $file,
            //         $fileName
            //     );

            //     $partner->logo_path = $fileName;
            // }

            $partner->save();
            DB::commit();

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner updaetd successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(
                'error',
                'An error occurred while updating the partner: ' . $th->getMessage()
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $partner = Partner::findOrFail($id);

            // Delete logo file
            if (!empty($partner->logo_path)) {
                $filePath = public_path('storage/images/partners/' . $partner->logo_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $partner->delete();
            DB::commit();

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(
                'error',
                'An error occurred while deleting the partner: ' . $th->getMessage()
            );
        }
    }
}
