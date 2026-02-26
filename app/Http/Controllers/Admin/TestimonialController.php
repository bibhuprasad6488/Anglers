<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderByDesc('id')->get()->map(function ($t) {
            $t->client_photo_path = $t->client_photo_path ? asset('storage/images/testimonials/' . $t->client_photo_path) : '';
            return $t;
        });
        return view('admin.testimonials.list', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255|unique:testimonials,client_name',
            'client_position' => 'nullable|string|max:255',
            // 'client_photo_path' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp',
            'testimonial_text' => 'required|string',
            // 'client_company' => 'nullable|string|max:255',
            // 'client_rating' => 'required|numeric|min:1|max:5',
        ]);

        DB::beginTransaction();
        try {
            $testimonial = new Testimonial();
            $testimonial->client_name = $request->client_name;
            $testimonial->client_position = $request->client_position;
            $testimonial->client_rating = $request->client_rating;
            $testimonial->testimonial_text = $request->testimonial_text;

            // /** Upload Path */
            $destinationPath = public_path('storage/images/testimonials/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('client_photo_path')) {
                $file = $request->file('client_photo_path');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->client_name) . '_' . time() . '.webp';
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

                $testimonial->client_photo_path = $imageName;
            }

            $testimonial->save();
            DB::commit();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Something went wrong! ' . $th->getMessage());
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
        $t = Testimonial::findOrFail($id);
        $t->client_photo_path = $t->client_photo_path ? asset('storage/images/testimonials/' . $t->client_photo_path) : '';
        return view('admin.testimonials.edit', compact('t'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'client_name' => 'required|string|max:255|unique:testimonials,client_name,' . $id,
            'client_position' => 'nullable|string|max:255',
            // 'client_photo_path' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp',
            'testimonial_text' => 'required|string',
            // 'client_company' => 'nullable|string|max:255',
            // 'client_rating' => 'required|numeric|min:1|max:5',
        ]);

        DB::beginTransaction();
        try {
            $testimonial =  Testimonial::find($id);
            $testimonial->client_name = $request->client_name;
            $testimonial->client_position = $request->client_position;
            $testimonial->client_rating = $request->client_rating;
            $testimonial->testimonial_text = $request->testimonial_text;

            // /** Upload Path */
            $destinationPath = public_path('storage/images/testimonials/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('client_photo_path')) {
                $file = $request->file('client_photo_path');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->client_name) . '_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($testimonial->client_photo_path)) {
                    $oldFilePath = $destinationPath . $testimonial->client_photo_path;
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

                $testimonial->client_photo_path = $imageName;
            }

            $testimonial->save();
            DB::commit();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Something went wrong! ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
