<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caseStudies = CaseStudy::orderByDesc('id')->with('topic')->get()->map(function ($cs) {
            // $cs->image = isset($cs->image) ? Storage::disk('public')->url('images/case_studies/' . $cs->image) : '';
            $cs->image = isset($cs->image) ? asset('storage/images/case_studies/' . $cs->image) : '';
            return $cs;
        });
        return view('admin.case_studies.list', compact('caseStudies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::orderByDesc('id')->get();
        return view('admin.case_studies.add', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255|unique:case_studies,title',
            'topic_id'       => 'required',
            'short_desc'     => 'nullable|string',
            'long_desc'      => 'nullable|string',
            'meta_title'     => 'nullable|string|max:255',
            'meta_keywords'  => 'nullable|string',
            'meta_desc'      => 'nullable|string',
            'image'          => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
        ]);

        DB::beginTransaction();

        try {
            $caseStudy = new CaseStudy();
            $caseStudy->title         = $request->title;
            $caseStudy->slug          = Str::slug($request->title);
            $caseStudy->user_id       = Auth::guard('admin')->user()->id;
            $caseStudy->topic_id      = $request->topic_id;
            $caseStudy->short_desc    = $request->short_desc;
            $caseStudy->long_desc     = $request->long_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->long_desc) : '';
            $caseStudy->meta_title    = $request->meta_title;
            $caseStudy->meta_keywords = $request->meta_keywords;
            $caseStudy->meta_desc     = $request->meta_desc;

            /** Upload Path */
            $destinationPath = public_path('storage/images/case_studies/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            /** Image Handling */
            if ($request->hasFile('image')) {
                $uploadedImage = $request->file('image');
                $extension = strtolower($uploadedImage->getClientOriginalExtension());

                $imageName = Str::slug($request->title) . '_' . time() . '.webp';
                $fullPath  = $destinationPath . $imageName;

                if ($extension === 'webp') {
                    // Direct move if already WebP
                    $uploadedImage->move($destinationPath, $imageName);
                } else {
                    // Convert to WebP
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                            $image = imagecreatefromjpeg($uploadedImage->getRealPath());
                            break;

                        case 'png':
                            $image = imagecreatefrompng($uploadedImage->getRealPath());
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

                $caseStudy->image = $imageName;
            }

            $caseStudy->save();
            DB::commit();

            return redirect()
                ->route('admin.case-studies.index')
                ->with('success', 'Case Study created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong! ' . $th->getMessage());
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
        $cs = CaseStudy::findOrFail($id);
        // $cs->image = isset($cs->image) ? Storage::disk('public')->url('images/case_studies/' . $cs->image) : '';
        $cs->image = isset($cs->image) ? asset('storage/images/case_studies/' . $cs->image) : '';
        $topics = Topic::orderByDesc('id')->get();
        return view('admin.case_studies.edit', compact('cs', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:case_studies,title,' . $id,
            'topic_id' => 'required',
            'short_desc' => 'nullable|string',
            'long_desc' => 'nullable|string',
            'mata_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_desc' => 'nullable|string',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp'
        ]);

        DB::beginTransaction();
        try {
            $caseStudy =  CaseStudy::findOrFail($id);
            $caseStudy->title = $request->title;
            $caseStudy->slug = Str::slug($request->title);
            $caseStudy->user_id      = Auth::guard('admin')->user()->id;
            $caseStudy->topic_id = $request->topic_id;
            $caseStudy->short_desc = $request->short_desc ?? null;
            $caseStudy->long_desc = $request->long_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->long_desc) : '';
            $caseStudy->meta_title = $request->meta_title ?? null;
            $caseStudy->meta_keywords = $request->meta_keywords ?? null;
            $caseStudy->meta_desc = $request->meta_desc ?? null;

            /** Upload Path */
            $destinationPath = public_path('storage/images/case_studies/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('image')) {
                $uploadedImage = $request->file('image');
                $extension = strtolower($uploadedImage->getClientOriginalExtension());

                $imageName = Str::slug($request->title) . '_' . time() . '.webp';
                $fullPath  = $destinationPath . $imageName;

                // Delete old image if exists
                if ($caseStudy->image && file_exists($destinationPath . $caseStudy->image)) {
                    unlink($destinationPath . $caseStudy->image);
                }

                if ($extension === 'webp') {
                    // Direct move if already WebP
                    $uploadedImage->move($destinationPath, $imageName);
                } else {
                    // Convert to WebP
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                            $image = imagecreatefromjpeg($uploadedImage->getRealPath());
                            break;

                        case 'png':
                            $image = imagecreatefrompng($uploadedImage->getRealPath());
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

                $caseStudy->image = $imageName;
            }

            // if ($request->hasFile('image')) {

            //     $file = $request->file('image');

            //     $fileName = preg_replace('/\s+/', '_', Str::slug($request->name))
            //         . '_' . time()
            //         . '.' . $file->getClientOriginalExtension();

            //     // Delete old image if exists
            //     if (
            //         !empty($caseStudy->image) &&
            //         Storage::disk('public')->exists('images/case_studies/' . $caseStudy->image)
            //     ) {

            //         Storage::disk('public')->delete('images/case_studies/' . $caseStudy->image);
            //     }

            //     // ✅ Correct usage
            //     Storage::disk('public')->putFileAs(
            //         'images/case_studies',
            //         $file,
            //         $fileName
            //     );

            //     $caseStudy->image = $fileName;
            // }

            $caseStudy->save();
            DB::commit();
            return redirect()->route('admin.case-studies.index')->with('success', 'Case Study updated successfully.');
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
        DB::beginTransaction();
        try {
            $caseStudy = CaseStudy::findOrFail($id);

            // Delete old image if exists
            if (!empty($caseStudy->image)) {
                $filePath = public_path('storage/images/case_studies' . $caseStudy->image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $caseStudy->delete();
            DB::commit();
            return redirect()->route('admin.case-studies.index')->with('success', 'Case study deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong! ' . $th->getMessage());
        }
    }
}
