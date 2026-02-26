<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::orderByDesc('id')->get();
        return view('admin.topics.list', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.topics.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:topics,name',
            'description' => 'nullable',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'banner_image' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'thumb_image' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        DB::beginTransaction();
        try {

            $topic = new Topic();
            $topic->name = $request->name;
            $topic->slug = Str::slug($request->name);
            $topic->description = preg_replace('/[^\x20-\x7E]/u', '', $request->description);

            $destinationPath = public_path('storage/images/topics/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('thumb_image')) {
                $file = $request->file('thumb_image');
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

                $topic->thumb_image = $imageName;
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

                $topic->banner_image = $imageName;
            }

            // Banner Image Upload
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_icon_' . time() . '.webp';
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

                $topic->icon = $imageName;
            }
            $topic->save();
            DB::commit();
            return redirect()->route('admin.topics.index')->with('success', 'Topic created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Topic creation failed Error: ' . $th->getMessage());
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
        $topic = Topic::find($id);
        return view('admin.topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:topics,name,' . $id,
            'description' => 'nullable',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'banner_image' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'thumb_image' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        DB::beginTransaction();
        try {
            $topic =  Topic::find($id);
            $topic->name = $request->name;
            $topic->slug = Str::slug($request->name);
            $topic->description = preg_replace('/[^\x20-\x7E]/u', '', $request->description);

            $destinationPath = public_path('storage/images/topics/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('thumb_image')) {
                $file = $request->file('thumb_image');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($topic->thumb_image)) {
                    $oldFilePath = $destinationPath . $topic->thumb_image;
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

                $topic->thumb_image = $imageName;
            }

            // Banner Image Upload
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_banner_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($topic->banner_image)) {
                    $oldFilePath = $destinationPath . $topic->banner_image;
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

                $topic->banner_image = $imageName;
            }

            // Banner Image Upload
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $extension = strtolower($file->getClientOriginalExtension());

                // Always store as .webp
                $imageName = Str::slug($request->name) . '_icon_' . time() . '.webp';
                $fullPath = $destinationPath . $imageName;

                // Delete old file first
                if (!empty($topic->icon)) {
                    $oldFilePath = $destinationPath . $topic->icon;
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

                $topic->icon = $imageName;
            }
            $topic->save();
            DB::commit();
            return redirect()->route('admin.topics.index')->with('success', 'Topic updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Topic update failed Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $topic =  Topic::find($id);

            $destinationPath = public_path('storage/images/topics/');

            // Delete old file first
            if (!empty($topic->thumb_image)) {
                $oldFilePath = $destinationPath . $topic->thumb_image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Delete old file first
            if (!empty($topic->banner_image)) {
                $oldFilePath = $destinationPath . $topic->banner_image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Delete old file first
            if (!empty($topic->icon)) {
                $oldFilePath = $destinationPath . $topic->icon;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $topic->delete();
            return redirect()->back()->with('success', 'Topic deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Topic delete failed Error: ' . $th->getMessage());
        }
    }
}
