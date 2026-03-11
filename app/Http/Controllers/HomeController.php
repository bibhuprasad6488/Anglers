<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CmsContactPage;
use App\Models\CmsGallery;
use App\Models\CmsHomePage;
use App\Models\CmsResource;
use App\Models\GetInTouch;
use App\Models\PrivacyPolicy;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\SiteSetting;
use App\Models\TermsOfBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_page_data = CmsHomePage::find(1);
        if ($home_page_data) {
            $home_page_data->banner_img = $home_page_data->banner_img ? asset('storage/images/cmspage/' . $home_page_data->banner_img) : '';
            $home_page_data->setion_one_img = $home_page_data->setion_one_img ? asset('storage/images/cmspage/' . $home_page_data->setion_one_img) : '';
            $home_page_data->setion_two_img = $home_page_data->setion_two_img ? asset('storage/images/cmspage/' . $home_page_data->setion_two_img) : '';
        }

        $galleries = CmsGallery::orderBy('id')->where('status', 1)->get()->map(function ($g) {
            $g->img_path = $g->img_path ? asset('storage/images/cmspage/' . $g->img_path) : '';
            return $g;
        });

        $siteSetting = SiteSetting::find(1);
        return view('home', compact('siteSetting', 'home_page_data', 'galleries'));
    }

    public function resourcesPageDetails()
    {
        $resourcePage = CmsResource::find(1);

        if ($resourcePage) {
            $resourcePage->setion_one_img = $resourcePage->setion_one_img ? asset('storage/images/cmspage/' . $resourcePage->setion_one_img) : '';
            $resourcePage->setion_two_img = $resourcePage->setion_two_img ? asset('storage/images/cmspage/' . $resourcePage->setion_two_img) : '';
        }
        return view('resources_page', compact('resourcePage'));
    }

    public function galleryPageDetails()
    {
        $galleries = CmsGallery::orderBy('id')->where('status', 1)->get()->map(function ($g) {
            $g->img_path = $g->img_path ? asset('storage/images/cmspage/' . $g->img_path) : '';
            return $g;
        });
        return view('gallery_page', compact('galleries'));
    }

    public function contactUs()
    {
        $siteSetting = SiteSetting::find(1);
        $contactPage = CmsContactPage::find(1);
        return view('contact', compact('siteSetting', 'contactPage'));
    }

    public function contactUsStore(Request $request)
    {
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => config('app.recaptcha_secret'),
        //     'response' => $request->input('g-recaptcha-response'),
        //     'remoteip' => $request->ip(),
        // ]);

        // if (!$response->json('success')) {
        //     return back()->with('error', 'CAPTCHA verification failed. Please try again.');
        // }

        $siteSetting = SiteSetting::find(1);

        DB::beginTransaction();
        try {
            $c = new GetInTouch();
            $c->ct_name = $request->ct_name;
            $c->ct_email = $request->ct_email;
            $c->ct_phone = $request->ct_phone;
            $c->ct_subject = $request->ct_subject;
            $c->ct_message = $request->ct_message;
            $c->ip_address = request()->ip();
            $c->save();

            $adminEmail = $siteSetting->contact_email ?? $siteSetting->alt_email;
            $internalRecipients = [
                'bibhuprasad.maastrix@gmail.com',
                $adminEmail
            ];

            $internalSubject = "New Contact Requested: {$c->ct_name}";
            $internalMessage = "A new contact form has been submitted on Website.\n\n" .
                "Name: {$c->ct_name}\n" .
                "Email: {$c->ct_email}\n" .
                "Phone: {$c->ct_phone}\n" .
                "Subject: {$c->ct_subject}\n" .
                "Message: {$c->ct_message}\n";

            Mail::raw($internalMessage, function ($message) use ($internalSubject, $internalRecipients, $c) {
                $message->to($internalRecipients)->subject($internalSubject);
                // ->replyTo($c->ct_email, $c->ct_name);
            });

            DB::commit();
            return redirect()->back()->with('success', 'Thank you for contacting us. We will get back to you as soon as possible');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error during submission: ' . $th->getMessage());
        }
    }
    public function blogLists()
    {
        $blogs = Blog::where('status', 1)->orderBy('id')->paginate(5);
        return view('blogs', compact('blogs'));
    }

    public function blogDetails($id)
    {
        $blog = Blog::where('slug', $id)->first();

        if ($blog) {
            $blog->blog_img = $blog->blog_img
                ? asset('storage/images/blog_images/' . $blog->blog_img)
                : '';

            // Previous post
            $previous = Blog::where('id', '<', $blog->id)
                ->orderBy('id', 'desc')
                ->first();

            // Next post
            $next = Blog::where('id', '>', $blog->id)
                ->orderBy('id', 'asc')
                ->first();
        }

        $siteSetting = SiteSetting::find(1);

        return view('blog_details', compact('blog', 'siteSetting', 'previous', 'next'));
    }

    public function catProperties($id)
    {
        $cat = PropertyCategory::where('slug', $id)->first();
        $properties = Property::where('category_id', $cat->id)->with('images')->where('status', 1)->get()->map(function ($p) {
            $p->images = $p->images->map(function ($img) {
                $img->img_path = $img->img_path ? asset('storage/images/property/' . $img->img_path) : '';
                return $img;
            });
            return $p;
        });
        return view('properties', compact('cat', 'properties'));
    }

    public function thankYou()
    {
        return view('thank_you');
    }

    public function privacyPolicy()
    {
        $privacy = PrivacyPolicy::find(1);
        return view('privacy_policy', compact('privacy'));
    }

    public function termsOfBusiness()
    {
        $term = TermsOfBusiness::find(1);
        return view('terms_of_business', compact('term'));
    }
}
