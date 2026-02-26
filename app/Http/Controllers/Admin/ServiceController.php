<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderByDesc('id')->get()->map(function ($s) {
            $s->service_image = $s->service_image ? asset('storage/images/services/' . $s->service_image) : asset('storage/images/no_img.png');
            return $s;
        });
        return view('admin.services.list', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:services,name',
            'description' => 'nullable',
            'service_image' => 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);
        DB::beginTransaction();
        try {
            $service = new Service();
            $service->name = $request->name;
            $service->slug = Str::slug($request->name);
            $service->description = preg_replace('/[^\x20-\x7E]/u', '', $request->description);
            $service->meta_title    = $request->meta_title;
            $service->meta_keywords = $request->meta_keywords;
            $service->meta_desc     = $request->meta_desc;
            // /** Upload Path */
            $destinationPath = public_path('storage/images/services/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('service_image')) {
                $file = $request->file('service_image');
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

                $service->service_image = $imageName;
            }

            // Banner Image Upload
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_banner_' . time() . '.webp';
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

                $service->banner_image = $imageName;
            }

            $service->save();
            DB::commit();
            return redirect()->route('admin.services.index')
                ->with('success', 'Service created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
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
        $service = Service::find($id);
        $service->service_image = $service->service_image ? asset('storage/images/services/' . $service->service_image) : '';
        $service->banner_image = $service->banner_image ? asset('storage/images/services/' . $service->banner_image) : '';
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:services,name,' . $id,
            'description' => 'nullable',
            'service_image' => 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);
        DB::beginTransaction();
        try {
            $service = Service::find($id);
            $service->name = $request->name;
            $service->slug = Str::slug($request->name);
            $service->description = preg_replace('/[^\x20-\x7E]/u', '', $request->description);
            $service->meta_title    = $request->meta_title;
            $service->meta_keywords = $request->meta_keywords;
            $service->meta_desc     = $request->meta_desc;

            // /** Upload Path */
            $destinationPath = public_path('storage/images/services/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('service_image')) {
                $file = $request->file('service_image');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($service->service_image)) {
                    $oldFilePath = $destinationPath . $service->service_image;
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

                $service->service_image = $imageName;
            }

            // Banner Image Upload
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_banner_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($service->banner_image)) {
                    $oldFilePath = $destinationPath . $service->banner_image;
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

                $service->banner_image = $imageName;
            }

            $service->save();
            DB::commit();
            return redirect()->route('admin.services.index')
                ->with('success', 'Service updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $service = Service::find($id);

            $destinationPath = public_path('storage/images/services/');
            // Delete old file first
            if (!empty($service->service_image)) {
                $oldFilePath = $destinationPath . $service->service_image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $service->delete();

            return redirect()->route('admin.services.index')
                ->with('success', 'Service updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
}
