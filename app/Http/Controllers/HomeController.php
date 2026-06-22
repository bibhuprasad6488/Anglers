<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Booking;
use App\Models\CmsContactPage;
use App\Models\CmsGallery;
use App\Models\CmsHomePage;
use App\Models\CmsResource;
use App\Models\GetInTouch;
use App\Models\HomePageGallery;
use App\Models\PrivacyPolicy;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\SiteSetting;
use App\Models\TermsOfBusiness;
use Carbon\Carbon;
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

        $properties = Property::with('images')->where('status', 1)->orderBy('title')->limit(30)->get()->map(function ($p) {
            $p->thumbnail = $p->thumbnail ? asset('storage/images/property/' . $p->thumbnail) : asset('assets/images/no-img.png');
            $p->images = $p->images->map(function ($img) {
                $img->img_path = $img->img_path ? asset('storage/images/property/' . $img->img_path) : '';
                return $img;
            });
            return $p;
        });
        $siteSetting = SiteSetting::find(1);
        $homwPageGallery = HomePageGallery::all()->map(function ($pg) {
            $pg->images = $pg->images ? asset('storage/images/cmspage/' . $pg->images) : '';
            return $pg;
        });
        return view('home', compact('siteSetting', 'home_page_data', 'galleries', 'properties', 'homwPageGallery'));
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
        $galleries = CmsGallery::orderBy('id')->where('status', 1)->paginate(24);
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
            // Format existing images
            $images = $p->images->map(function ($img) {
                $img->img_path = $img->img_path
                    ? asset('storage/images/property/' . $img->img_path)
                    : '';

                return $img;
            });

            // Randomly arrange images first
            $images = $images->shuffle();

            if ($p->thumbnail) {
                $thumbnailUrl = $p->thumbnail
                    ? asset('storage/images/property/' . $p->thumbnail)
                    : asset('assets/images/no-img.png');

                $p->thumbnail = $thumbnailUrl;
                // Add thumbnail as first image
                if ($thumbnailUrl) {
                    $thumbnailObj = (object) [
                        'id' => 0,
                        'img_path' => $thumbnailUrl,
                        'is_thumbnail' => true,
                    ];

                    $images->prepend($thumbnailObj);
                }
            }

            $p->images = $images->values();


            return $p;
        });

        $suggestedProperties = Property::where('category_id', '!=', $cat->id)->with('images')
            ->where('status', 1)->orderBy('title')->limit(6)->get()->map(function ($p) {
                // Format existing images
                $images = $p->images->map(function ($img) {
                    $img->img_path = $img->img_path
                        ? asset('storage/images/property/' . $img->img_path)
                        : '';

                    return $img;
                });

                if ($p->thumbnail) {
                    $thumbnailUrl = $p->thumbnail
                        ? asset('storage/images/property/' . $p->thumbnail)
                        : asset('assets/images/no-img.png');

                    $p->thumbnail = $thumbnailUrl;
                    // Add thumbnail as first image
                    if ($thumbnailUrl) {
                        $thumbnailObj = (object) [
                            'id' => 0,
                            'img_path' => $thumbnailUrl,
                            'is_thumbnail' => true,
                        ];

                        $images->prepend($thumbnailObj);
                    }
                }

                $p->images = $images->values();
                return $p;
            });
        return view('properties', compact('cat', 'properties', 'suggestedProperties'));
    }

    public function catPropertiesFilter(Request $request, $id)
    {
        $propertyId = $request->query('prop_id');
        try {
            // Get category by slug
            $cat = PropertyCategory::where('id', $id)->firstOrFail();
            $properties = Property::where('category_id', $cat->id)->with('images')->where('status', 1)->get()->map(function ($p) {
                // Format existing images
                $images = $p->images->map(function ($img) {
                    $img->img_path = $img->img_path
                        ? asset('storage/images/property/' . $img->img_path)
                        : '';

                    return $img;
                });

                if ($p->thumbnail) {
                    $thumbnailUrl = $p->thumbnail
                        ? asset('storage/images/property/' . $p->thumbnail)
                        : asset('assets/images/no-img.png');

                    $p->thumbnail = $thumbnailUrl;
                    // Add thumbnail as first image
                    if ($thumbnailUrl) {
                        $thumbnailObj = (object) [
                            'id' => 0,
                            'img_path' => $thumbnailUrl,
                            'is_thumbnail' => true,
                        ];

                        $images->prepend($thumbnailObj);
                    }
                }

                $p->images = $images->values();


                return $p;
            });
            $html = '
            <select name="property_id" id="property_id" class="form-control border-secondary" required>
                <option value="" disabled ' . (!$propertyId ? 'selected' : '') . '>Select Property</option>';

            if ($properties->isEmpty()) {
                $html .= '<option disabled>No properties found</option>';
            } else {
                foreach ($properties as $value) {
                    $selected = ($propertyId && $propertyId == $value->id) ? 'selected' : '';
                    $html .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->title . '</option>';
                }
            }

            $html .= '</select>';

            return response()->json(['status' => true, 'message' => 'Passed', 'html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Failed Error: ' . $th->getMessage()]);
        }
    }


    public function propertyDetails($id)
    {
        $property = Property::where('slug', $id)->with('images', 'category')->first();
        if ($property) {

            $thumbnailUrl = $property->thumbnail
                ? asset('storage/images/property/' . $property->thumbnail)
                : asset('assets/images/no-img.png');

            $property->thumbnail = $thumbnailUrl;

            // Format existing images
            $images = $property->images->map(function ($img) {
                $img->img_path = $img->img_path
                    ? asset('storage/images/property/' . $img->img_path)
                    : '';

                return $img;
            });

            // Add thumbnail as first image
            if ($thumbnailUrl) {
                $thumbnailObj = (object) [
                    'id' => 0,
                    'img_path' => $thumbnailUrl,
                    'is_thumbnail' => true,
                ];

                $images->prepend($thumbnailObj);
            }

            $property->images = $images->values();
        }

        $home_page_data = CmsHomePage::find(1);
        if ($home_page_data) {
            $home_page_data->banner_img = $home_page_data->banner_img ? asset('storage/images/cmspage/' . $home_page_data->banner_img) : '';
            $home_page_data->setion_one_img = $home_page_data->setion_one_img ? asset('storage/images/cmspage/' . $home_page_data->setion_one_img) : '';
            $home_page_data->setion_two_img = $home_page_data->setion_two_img ? asset('storage/images/cmspage/' . $home_page_data->setion_two_img) : '';
        }
        $siteSetting = SiteSetting::find(1);
        return view('property_details', compact('property', 'home_page_data', 'siteSetting'));
    }

    public function searchFormResult(Request $request)
    {
        $formDate = $request->input('check_in_date') ?? $request->input('check_in');
        $toDate = $request->input('check_out_date') ?? $request->input('check_out');
        $propertyId = $request->input('property_id');
        $categoryId = $request->input('category_id');
        $typeVal = $request->input('type_val');

        $bookedDates = [];
        $bookedIds = [];
        $pricing = [];

        if ($formDate && ($toDate || $request->input('duration')) && $propertyId && $categoryId) {

            // $checkBooking = Booking::where('property_id', $propertyId)
            //     ->where('category_id', $categoryId)
            //     ->where('status', '!=', 'locked')
            //     ->orWhere('status', '!=', 'confirmed')
            //     ->where(function ($query) use ($formDate, $toDate) {
            //         $query->whereBetween('check_in', [$formDate, $toDate])
            //             ->orWhereBetween('check_out', [$formDate, $toDate])
            //             ->orWhere(function ($q) use ($formDate, $toDate) {
            //                 $q->where('check_in', '<=', $formDate)
            //                     ->where('check_out', '>=', $toDate);
            //             });
            //     })
            //     ->exists();
            $duration = $request->input('duration');

            $checkIn = Carbon::parse($formDate);

            if (in_array($categoryId, [1, 3])) {

                if ($duration == 3) {
                    $checkOut = $checkIn->copy()->addMonths(3);
                } elseif ($duration == 2) {
                    $checkOut = $checkIn->copy()->addMonths(2);
                } else {
                    $checkOut = $checkIn->copy()->addMonth();
                }
            } else {
                $checkOut = Carbon::createFromFormat('Y-m-d', $toDate);
            }

            $formDate = $checkIn->format('Y-m-d');
            $toDate = $checkOut->format('Y-m-d');

            $checkBooking = Booking::where('property_id', $propertyId)
                ->where('category_id', $categoryId)
                ->whereIn('status', ['locked', 'confirmed']) // ✅ correct
                ->where(function ($query) use ($formDate, $toDate) {
                    $query->where('check_in', '<', $toDate)
                        ->where('check_out', '>', $formDate);
                })
                ->first();

            if ($checkBooking) {
                $bookedIds = Booking::whereIn('status', ['locked', 'confirmed'])
                    ->where('check_in', '<', $toDate)
                    ->where('check_out', '>', $formDate)
                    ->pluck('property_id')
                    ->toArray();

                $properties = Property::whereNotIn('id', $bookedIds)
                    ->where('status', 1)
                    ->with('images')
                    ->get()
                    ->map(function ($p) use ($formDate, $toDate) {

                        // Format existing images
                        $images = $p->images->map(function ($img) {
                            $img->img_path = $img->img_path
                                ? asset('storage/images/property/' . $img->img_path)
                                : '';
                            return $img;
                        });

                        if ($p->thumbnail) {
                            $thumbnailUrl = $p->thumbnail
                                ? asset('storage/images/property/' . $p->thumbnail)
                                : asset('assets/images/no-img.png');

                            $p->thumbnail = $thumbnailUrl;
                            // Add thumbnail as first image
                            if ($thumbnailUrl) {
                                $thumbnailObj = (object) [
                                    'id' => 0,
                                    'img_path' => $thumbnailUrl,
                                    'is_thumbnail' => true,
                                ];

                                $images->prepend($thumbnailObj);
                            }
                        }

                        $p->images = $images->values();
                        $p->pricing = $this->getFinalBookingPrice($p->id, $formDate, $toDate);

                        return $p;
                    });


                $messageD = [
                    'type' => 'error',
                    'message' => 'Selected Dates are not available for that property. Please select different dates.'
                ];
                return back()->with('error', 'This property is booked from ' . Carbon::parse($checkBooking->check_in)->format('F d, Y') . ' to ' . Carbon::parse($checkBooking->check_out)->format('F d, Y') . '. Please select different dates.');
                // return view('search_result', compact('formDate', 'toDate', 'categoryId', 'propertyId', 'messageD', 'properties'));
            } else {
                if ($typeVal == 'book_now') {
                    return view('search_result', compact('formDate', 'toDate', 'categoryId', 'propertyId'));
                } else {
                    DB::beginTransaction();
                    try {
                        $pricing = $this->getFinalBookingPrice($propertyId, $formDate, $toDate);

                        $lastBooking = Booking::latest('id')->first();

                        if ($lastBooking) {
                            // Extract last number
                            $lastNumber = (int) substr($lastBooking->booking_id, -4);
                            $newNumber = $lastNumber + 1;
                        } else {
                            $newNumber = 1;
                        }

                        // Generate formatted booking number
                        $bookingNo = 'BK-' . date('Y') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

                        // create new booking
                        $booking = new Booking();
                        $booking->booking_id = $bookingNo;
                        $booking->property_id = $propertyId;
                        $booking->category_id = $categoryId;
                        $booking->check_in = $formDate;
                        $booking->check_out = $toDate;
                        $booking->total_nights = $pricing['total_days'];
                        $booking->booking_amount = $pricing['final_price'];
                        $booking->save();
                        DB::commit();

                        return redirect()->route('booking.confirm', $booking->booking_id);
                    } catch (\Throwable $th) {
                        DB::rollBack();

                        $messageD = [
                            'type' => 'error',
                            'message' => 'Error: ' . $th->getMessage()
                        ];
                        return view('search_result', compact('formDate', 'toDate', 'categoryId', 'propertyId', 'messageD'));
                    }
                }
            }
        } else if ($formDate && ($toDate || $request->input('duration')) && $categoryId) {
            $duration = $request->input('duration');

            $checkIn = Carbon::parse($formDate);

            if (in_array($categoryId, [1, 3])) {

                if ($duration == 3) {
                    $checkOut = $checkIn->copy()->addMonths(3);
                } elseif ($duration == 2) {
                    $checkOut = $checkIn->copy()->addMonths(2);
                } else {
                    $checkOut = $checkIn->copy()->addMonth();
                }
            } else {
                $checkOut = Carbon::createFromFormat('Y-m-d', $toDate);
            }

            $formDate = $checkIn->format('Y-m-d');
            $toDate = $checkOut->format('Y-m-d');
            // dd(
            //     $formDate,
            //     $toDate
            // );
            $cat = PropertyCategory::find($categoryId);

            $bookedIds = Booking::where('category_id', $categoryId)
                ->whereIn('status', ['locked', 'confirmed'])
                ->where('check_in', '<', $toDate)
                ->where('check_out', '>', $formDate)
                ->pluck('property_id')
                ->toArray();

            $properties = Property::where('category_id', $categoryId)
                ->whereNotIn('id', $bookedIds)
                ->where('status', 1)
                ->with('images')
                ->get()
                ->map(function ($p) use ($formDate, $toDate) {

                    // Format existing images
                    $images = $p->images->map(function ($img) {
                        $img->img_path = $img->img_path
                            ? asset('storage/images/property/' . $img->img_path)
                            : '';

                        return $img;
                    });

                    if ($p->thumbnail) {
                        $thumbnailUrl = $p->thumbnail
                            ? asset('storage/images/property/' . $p->thumbnail)
                            : asset('assets/images/no-img.png');

                        $p->thumbnail = $thumbnailUrl;
                        // Add thumbnail as first image
                        if ($thumbnailUrl) {
                            $thumbnailObj = (object) [
                                'id' => 0,
                                'img_path' => $thumbnailUrl,
                                'is_thumbnail' => true,
                            ];

                            $images->prepend($thumbnailObj);
                        }
                    }

                    $p->images = $images->values();

                    $p->pricing = $this->getFinalBookingPrice($p->id, $formDate, $toDate);

                    return $p;
                });
            return view('search_result', compact('formDate', 'toDate', 'categoryId', 'propertyId', 'properties'));
        } else if ($formDate && $toDate) {
            $excludesCat = [1, 3];
            $bookedIds = Booking::whereIn('status', ['locked', 'confirmed'])
                ->where('check_in', '<', $toDate)
                ->where('check_out', '>', $formDate)
                ->pluck('property_id')
                ->toArray();

            $properties = Property::whereNotIn('id', $bookedIds)->whereNotIn('category_id', $excludesCat)
                ->where('status', 1)
                ->with('images')
                ->get()
                ->map(function ($p) use ($formDate, $toDate) {
                    // Format existing images
                    $images = $p->images->map(function ($img) {
                        $img->img_path = $img->img_path
                            ? asset('storage/images/property/' . $img->img_path)
                            : '';

                        return $img;
                    });

                    if ($p->thumbnail) {
                        $thumbnailUrl = $p->thumbnail
                            ? asset('storage/images/property/' . $p->thumbnail)
                            : asset('assets/images/no-img.png');

                        $p->thumbnail = $thumbnailUrl;
                        // Add thumbnail as first image
                        if ($thumbnailUrl) {
                            $thumbnailObj = (object) [
                                'id' => 0,
                                'img_path' => $thumbnailUrl,
                                'is_thumbnail' => true,
                            ];

                            $images->prepend($thumbnailObj);
                        }
                    }

                    $p->images = $images->values();
                    $p->pricing = $this->getFinalBookingPrice($p->id, $formDate, $toDate);

                    return $p;
                });
            // dd($properties);
            return view('search_result', compact('formDate', 'toDate', 'categoryId', 'propertyId', 'properties'));
        }
    }

    private function getFinalBookingPrice($propertyId, $formDate, $toDate)
    {

        // $adminTax = SiteSetting::find(1)->admin_tax ?? 5;
        $adminTax = 0;
        $finalTax = ($adminTax / 100);

        $property = Property::find($propertyId);
        $pricePerDay = $property->price_per_night;
        $pricePerWeek = $property->price_per_week;
        $pricePerMonth = $property->price_per_month;

        // Get days difference between two dates
        $checkIn = Carbon::createFromFormat('Y-m-d', $formDate);
        $checkOut = Carbon::createFromFormat('Y-m-d', $toDate);
        $daysDifference = $checkIn->diffInDays($checkOut);

        if (in_array($property->category_id, [1, 3])) {

            $monthsDiff = $checkIn->diffInMonths($checkOut);

            $finalPrice = $monthsDiff * $pricePerMonth;

            $totalAmount = round($finalPrice, 2);

            $priceWithTax = ($finalTax * $totalAmount) + $totalAmount;
            $priceWithOutTax = $priceWithTax / (1 + $adminTax / 100);

            return [
                'check_in' => $formDate,
                'check_out' => $toDate,
                'property' => $property,
                'total_days' => $daysDifference,
                'months' => $monthsDiff,
                'weeks' => 0,
                'days' => 0,
                'total_price' => $priceWithOutTax,
                'final_price' => $priceWithTax
            ];
        }
        // Get how many months, weeks and days between two dates
        $mothsDiff = 0;
        $dayleft = 0;
        $weeksDiff = 0;
        $daysLeftAfterWeeksDiff = 0;
        if ($daysDifference > 30) {
            $mothsDiff = floor($daysDifference / 30);
            $dayleft = $daysDifference % 30;
            if ($dayleft > 0) {
                // $mothsDiff = $mothsDiff - ($dayleft / 30);
                $weeksDiff = floor($dayleft / 7);
                $daysLeftAfterWeeksDiff = $dayleft % 7;
            }
        } else if ($daysDifference > 7) {
            $weeksDiff = floor($daysDifference / 7);
            $daysLeftAfterWeeksDiff = $daysDifference % 7;
        } else {
            $daysLeftAfterWeeksDiff = $daysDifference;
        }

        // Calculate final price
        $finalPrice =
            ($mothsDiff * $pricePerMonth) +
            ($weeksDiff * $pricePerWeek) +
            ($daysLeftAfterWeeksDiff * $pricePerDay);


        $totalAmount = round($finalPrice, 2);

        $priceWithTax = ($finalTax *  $totalAmount) +  $totalAmount;
        $priceWithOutTax = $priceWithTax / (1 + $adminTax / 100);

        return [
            'check_in' => $formDate,
            'check_out' => $toDate,
            'property' => $property,
            'total_days' => $daysDifference,
            'months' => $mothsDiff,
            'weeks' => $weeksDiff,
            'days' => $daysLeftAfterWeeksDiff,
            'total_price' => $priceWithOutTax,
            'final_price' =>  $priceWithTax
        ];
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
