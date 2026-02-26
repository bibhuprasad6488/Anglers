<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\GetInTouch;
use App\Models\GuidedJourney;
use App\Models\OurStory;
use App\Models\PrivacyPolicy;
use App\Models\ProtectionPage;
use App\Models\SiteSetting;
use App\Models\TermsOfBusiness;
use App\Models\User;
use App\Models\Will;
use App\Models\WitnessesPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }
        $adminUser = Admin::findOrFail($admin->id);
        return view('admin.setting.profile', compact('adminUser'));
    }

    public function chnagePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
        ]);
        // dd($request->all());

        $admin = Auth::guard('admin')->user();
        try {

            $user = Admin::find($admin->id);
            if ($user && !Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current Password does not match');
            }

            // Update the password
            $user->password = Hash::make($request->new_password);
            $user->plain_password = $request->new_password;
            $user->save();

            // Send raw email notification
            // Mail::raw("Hello {$user->name},\n\nYour password has been changed successfully for {$user->email}.\nIf you did not initiate this change, please contact support immediately.", function ($message) use ($user) {
            //     $message->to($user->email)
            //         ->subject('Password Changed Notification');
            // });


            // Logout immediately
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('success', 'Password changed successfully. Please login again.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function siteSetting()
    {
        $setting = SiteSetting::find(1);

        if ($setting) {
            $setting->site_logo = $setting->site_logo
                ? asset('storage/images/settings/' . $setting->site_logo)
                : '';

            $setting->footer_logo = $setting->footer_logo
                ? asset('storage/images/settings/' . $setting->footer_logo)
                : '';

            $setting->footer_logo_one = $setting->footer_logo_one
                ? asset('storage/images/settings/' . $setting->footer_logo_one)
                : '';

            $setting->footer_logo_two = $setting->footer_logo_two
                ? asset('storage/images/settings/' . $setting->footer_logo_two)
                : '';

            $setting->favicon = $setting->favicon
                ? asset('storage/images/settings/' . $setting->favicon)
                : '';
        }

        return view('admin.site_setting', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $admin = Admin::find($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->save();

            DB::commit();
            return back()->with('success', 'Profile Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Profile Update failed Error: ' . $th->getMessage());
        }
    }

    public function updateSiteSetting(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $setting = SiteSetting::find(1);
            if (!$setting) {
                $setting = new SiteSetting();
            }

            // Update fields
            $setting->site_title = $request->site_title;
            $setting->contact_email = $request->contact_email;
            $setting->alt_email = $request->alt_email;
            $setting->contact_phone = $request->contact_phone;
            $setting->alt_phone = $request->alt_phone;
            $setting->call_wp_number = $request->call_wp_number;
            $setting->wp_message = $request->wp_message;
            $setting->copyright = $request->copyright;
            $setting->site_desc = $request->site_desc;
            $setting->site_map_key = $request->site_map_key;
            $setting->address = $request->address;
            $setting->site_meta_desc = $request->site_meta_desc;
            $setting->site_meta_key = $request->site_meta_key;
            $setting->smtp_host = $request->smtp_host;
            $setting->smtp_port = $request->smtp_port;
            $setting->smtp_username = $request->smtp_username;
            $setting->smtp_password = $request->smtp_password;
            $setting->smtp_from_name = $request->smtp_from_name;
            $setting->smtp_from_email = $request->smtp_from_email;
            $setting->footer_text_one = $request->footer_text_one;
            $setting->footer_text_two = $request->footer_text_two;
            $setting->cta_title = $request->cta_title;
            $setting->cta_sub_title = $request->cta_sub_title;


            // /** Upload Path */
            $destinationPath = public_path('storage/images/settings/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Site Logo
            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                $siteLogo = 'Site_logo_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->site_logo)) {
                    $oldFilePath = $destinationPath . $setting->site_logo;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $siteLogo);

                $setting->site_logo = $siteLogo;
            }

            if ($request->hasFile('footer_logo')) {
                $file = $request->file('footer_logo');
                $footerLogo = 'Footer_logo_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->footer_logo)) {
                    $oldFilePath = $destinationPath . $setting->footer_logo;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogo);

                $setting->footer_logo = $footerLogo;
            }

            if ($request->hasFile('footer_logo_one')) {
                $file = $request->file('footer_logo_one');
                $footerLogoOne = 'Footer_logo_one_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->footer_logo_one)) {
                    $oldFilePath = $destinationPath . $setting->footer_logo_one;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoOne);

                $setting->footer_logo_one = $footerLogoOne;
            }


            if ($request->hasFile('footer_logo_two')) {
                $file = $request->file('footer_logo_two');
                $footerLogoTwo = 'Footer_logo_two_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->footer_logo_two)) {
                    $oldFilePath = $destinationPath . $setting->footer_logo_two;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoTwo);

                $setting->footer_logo_two = $footerLogoTwo;
            }

            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                $favicon = 'favicon_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->favicon)) {
                    $oldFilePath = $destinationPath . $setting->favicon;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $favicon);

                $setting->favicon = $favicon;
            }



            $setting->save();
            DB::commit();
            return back()->with('success', 'Site settings updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function getWills()
    {
        $wills = Will::orderByDesc('id')->get();
        return view('admin.common.wills', compact('wills'));
    }

    public function ViewWill($id)
    {
        $will = Will::find($id);
        return view('admin.common.view_will', compact('will'));
    }

    public function contactRequests()
    {
        $contacts = GetInTouch::orderByDesc('id')->get();
        return view('admin.common.contacts', compact('contacts'));
    }


    public function chnageAccess(Request $request)
    {
        $status = $request->status;
        $for = $request->change_for;
        // return response()->json($request->all());
        DB::beginTransaction();
        try {
            $setting = SiteSetting::find(1);
            if ($request->change_for === 'partner') {
                $setting->partner_show = $status;
            }
            $setting->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Access Updated Successfully', 'set' => $setting]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Access Update failed: ' . $th->getMessage()]);
        }
    }

    public function privacyPolicy()
    {
        $privacy = PrivacyPolicy::find(1);
        return view('admin.common.privacy', compact('privacy'));
    }
    public function privacyPolicyStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $privacy = PrivacyPolicy::find(1) ?? new PrivacyPolicy();
            $privacy->content = $request->content ? preg_replace('/[^\x20-\x7E]/u', '', $request->content) : '';
            $privacy->save();
            DB::commit();
            return back()->with('success', 'Content Saved Succefully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Content Saved failed Error: ' . $th->getMessage());
        }
    }
    public function termOfBusiness()
    {
        $term = TermsOfBusiness::find(1);
        return view('admin.common.terms', compact('term'));
    }
    public function termOfBusinessStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $term = TermsOfBusiness::find(1) ?? new TermsOfBusiness();
            $term->content = $request->content ? preg_replace('/[^\x20-\x7E]/u', '', $request->content) : '';
            $term->save();
            DB::commit();
            return back()->with('success', 'Content Saved Succefully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Content Saved failed Error: ' . $th->getMessage());
        }
    }

    public function ourStory()
    {
        $story = OurStory::find(1);
        return view('admin.common.story', compact('story'));
    }
    public function ourStoryStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $s =  OurStory::find(1) ?? new OurStory();
            $s->story_desc_one = $request->story_desc_one ? preg_replace('/[^\x20-\x7E]/u', '', $request->story_desc_one) : $s->story_desc_one;
            $s->ap_title_one = $request->ap_title_one;
            $s->ap_desc_one = $request->ap_desc_one;
            $s->ap_title_two = $request->ap_title_two;
            $s->ap_desc_two = $request->ap_desc_two;
            $s->ap_title_three = $request->ap_title_three;
            $s->ap_desc_three = $request->ap_desc_three;
            $s->story_desc_two = $request->story_desc_two ? preg_replace('/[^\x20-\x7E]/u', '', $request->story_desc_two) : $s->story_desc_two;
            $s->meta_title = $request->meta_title;
            $s->meta_desc = $request->meta_desc;
            $s->save();

            DB::commit();
            return back()->with('success', 'Content Saved Succefully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Content Saved failed Error: ' . $th->getMessage());
        }
    }
    public function guidedJourney()
    {
        $journey = GuidedJourney::find(1);
        if ($journey) {
            $journey->step_img_one = $journey->step_img_one ? asset('storage/images/journey/' . $journey->step_img_one) : '';
            $journey->step_img_two = $journey->step_img_two ? asset('storage/images/journey/' . $journey->step_img_two) : '';
            $journey->step_img_three = $journey->step_img_three ? asset('storage/images/journey/' . $journey->step_img_three) : '';
            $journey->step_img_four = $journey->step_img_four ? asset('storage/images/journey/' . $journey->step_img_four) : '';
        }

        return view('admin.common.guide', compact('journey'));
    }
    public function guidedJourneyStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $j =  GuidedJourney::find(1) ?? new GuidedJourney();

            $j->journey_desc = $request->journey_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->journey_desc) : $j->journey_desc;
            $j->step_title = $request->step_title;
            $j->step_sub_title = $request->step_sub_title;
            $j->step_title_one = $request->step_title_one;
            $j->step_sub_title_one = $request->step_sub_title_one;
            $j->step_desc_one = $request->step_desc_one;
            $j->step_title_two = $request->step_title_two;
            $j->step_sub_title_two = $request->step_sub_title_two;
            $j->step_desc_two = $request->step_desc_two;
            $j->step_title_three = $request->step_title_three;
            $j->step_sub_title_three = $request->step_sub_title_three;
            $j->step_desc_three = $request->step_desc_three;
            $j->step_title_four = $request->step_title_four;
            $j->step_sub_title_four = $request->step_sub_title_four;
            $j->step_desc_four = $request->step_desc_four;
            $j->meta_title = $request->meta_title;
            $j->meta_desc = $request->meta_desc;


            // /** Upload Path */
            $destinationPath = public_path('storage/images/journey/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            // Step One
            if ($request->hasFile('step_img_one')) {
                $file = $request->file('step_img_one');
                $footerLogoOne = 'step_img_one_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($j->step_img_one)) {
                    $oldFilePath = $destinationPath . $j->step_img_one;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoOne);

                $j->step_img_one = $footerLogoOne;
            }

            // Step Two
            if ($request->hasFile('step_img_two')) {
                $file = $request->file('step_img_two');
                $footerLogoTwo = 'step_img_two_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($j->step_img_two)) {
                    $oldFilePath = $destinationPath . $j->step_img_two;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoTwo);

                $j->step_img_two = $footerLogoTwo;
            }
            // Step Two
            if ($request->hasFile('step_img_three')) {
                $file = $request->file('step_img_three');
                $footerLogoThree = 'step_img_three_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($j->step_img_three)) {
                    $oldFilePath = $destinationPath . $j->step_img_three;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoThree);

                $j->step_img_three = $footerLogoThree;
            }

            // Step Two
            if ($request->hasFile('step_img_four')) {
                $file = $request->file('step_img_four');
                $footerLogoFour = 'step_img_four_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($j->step_img_four)) {
                    $oldFilePath = $destinationPath . $j->step_img_four;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoFour);

                $j->step_img_four = $footerLogoFour;
            }

            $j->save();

            DB::commit();
            return back()->with('success', 'Content Saved Succefully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Content Saved failed Error: ' . $th->getMessage());
        }
    }

    public function protection()
    {
        $protect = ProtectionPage::find(1);
        if ($protect) {
            $protect->p_image = $protect->p_image ? asset('storage/images/protections/' . $protect->p_image) : '';
            $protect->ps_img_one = $protect->ps_img_one ? asset('storage/images/protections/' . $protect->ps_img_one) : '';
            $protect->ps_img_two = $protect->ps_img_two ? asset('storage/images/protections/' . $protect->ps_img_two) : '';
            $protect->ps_img_three = $protect->ps_img_three ? asset('storage/images/protections/' . $protect->ps_img_three) : '';
            $protect->ps_img_four = $protect->ps_img_four ? asset('storage/images/protections/' . $protect->ps_img_four) : '';
            $protect->pp_img = $protect->pp_img ? asset('storage/images/protections/' . $protect->pp_img) : '';
            $protect->pw_img_one = $protect->pw_img_one ? asset('storage/images/protections/' . $protect->pw_img_one) : '';
            $protect->pw_img_two = $protect->pw_img_two ? asset('storage/images/protections/' . $protect->pw_img_two) : '';
            $protect->pw_img_three = $protect->pw_img_three ? asset('storage/images/protections/' . $protect->pw_img_three) : '';
            $protect->pw_img_four = $protect->pw_img_four ? asset('storage/images/protections/' . $protect->pw_img_four) : '';
        }

        return view('admin.common.protect', compact('protect'));
    }

    public function protectionStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $p =  ProtectionPage::find(1) ?? new ProtectionPage();

            $p->p_desc = $request->p_desc ? preg_replace('/[^\x20-\x7E]/u', '', $request->p_desc) : $p->p_desc;
            $p->ps_title_one = $request->ps_title_one;
            $p->ps_desc_one = $request->ps_desc_one;
            $p->ps_title_two = $request->ps_title_two;
            $p->ps_desc_two = $request->ps_desc_two;
            $p->ps_title_three = $request->ps_title_three;
            $p->ps_desc_three = $request->ps_desc_three;
            $p->ps_title_four = $request->ps_title_four;
            $p->ps_desc_four = $request->ps_desc_four;
            $p->pp_desc_one = $request->pp_desc_one;
            $p->pp_desc_two = $request->pp_desc_two;
            $p->pw_title_one = $request->pw_title_one;
            $p->pw_title_two = $request->pw_title_two;
            $p->pw_title_three = $request->pw_title_three;
            $p->pw_title_four = $request->pw_title_four;
            $p->pcta_title = $request->pcta_title;
            $p->pcta_btn_text = $request->pcta_btn_text;
            $p->pcta_btn_link = $request->pcta_btn_link;
            $p->meta_title = $request->meta_title;
            $p->meta_desc = $request->meta_desc;


            // /** Upload Path */
            $destinationPath = public_path('storage/images/protections/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            // Protection
            if ($request->hasFile('p_image')) {
                $file = $request->file('p_image');
                $pImage = 'p_image_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->p_image)) {
                    $oldFilePath = $destinationPath . $p->p_image;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $pImage);

                $p->p_image = $pImage;
            }

            // Protection Service
            if ($request->hasFile('ps_img_one')) {
                $file = $request->file('ps_img_one');
                $protectServiceImgOne = 'ps_img_one_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->ps_img_one)) {
                    $oldFilePath = $destinationPath . $p->ps_img_one;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectServiceImgOne);

                $p->ps_img_one = $protectServiceImgOne;
            }

            // Protection Service
            if ($request->hasFile('ps_img_two')) {
                $file = $request->file('ps_img_two');
                $protectServiceImgTwo = 'ps_img_two_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->ps_img_two)) {
                    $oldFilePath = $destinationPath . $p->ps_img_two;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectServiceImgTwo);

                $p->ps_img_two = $protectServiceImgTwo;
            }
            // Protection Service
            if ($request->hasFile('ps_img_three')) {
                $file = $request->file('ps_img_three');
                $protectServiceImgThree = 'ps_img_three_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->ps_img_three)) {
                    $oldFilePath = $destinationPath . $p->ps_img_three;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectServiceImgThree);

                $p->ps_img_three = $protectServiceImgThree;
            }

            // Protection Service
            if ($request->hasFile('ps_img_four')) {
                $file = $request->file('ps_img_four');
                $protectServiceImgFour = 'ps_img_four_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->ps_img_four)) {
                    $oldFilePath = $destinationPath . $p->ps_img_four;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectServiceImgFour);

                $p->ps_img_four = $protectServiceImgFour;
            }

            // Protection Partner
            if ($request->hasFile('pp_img')) {
                $file = $request->file('pp_img');
                $protectPartnerImgFour = 'pp_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->pp_img)) {
                    $oldFilePath = $destinationPath . $p->pp_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectPartnerImgFour);

                $p->pp_img = $protectPartnerImgFour;
            }

            // Protection Work
            if ($request->hasFile('pw_img_one')) {
                $file = $request->file('pw_img_one');
                $protectWorkImgOne = 'pw_img_one_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->pw_img_one)) {
                    $oldFilePath = $destinationPath . $p->pw_img_one;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectWorkImgOne);

                $p->pw_img_one = $protectWorkImgOne;
            }

            // Protection Work
            if ($request->hasFile('pw_img_two')) {
                $file = $request->file('pw_img_two');
                $protectWorkImgTwo = 'pw_img_two_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->pw_img_two)) {
                    $oldFilePath = $destinationPath . $p->pw_img_two;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectWorkImgTwo);

                $p->pw_img_two = $protectWorkImgTwo;
            }

            // Protection Work
            if ($request->hasFile('pw_img_three')) {
                $file = $request->file('pw_img_three');
                $protectWorkImgThree = 'pw_img_three_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->pw_img_three)) {
                    $oldFilePath = $destinationPath . $p->pw_img_three;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectWorkImgThree);

                $p->pw_img_three = $protectWorkImgThree;
            }

            // Protection Work
            if ($request->hasFile('pw_img_four')) {
                $file = $request->file('pw_img_four');
                $protectWorkImgFour = 'pw_img_four_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($p->pw_img_four)) {
                    $oldFilePath = $destinationPath . $p->pw_img_four;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectWorkImgFour);

                $p->pw_img_four = $protectWorkImgFour;
            }

            $p->save();

            DB::commit();
            return back()->with('success', 'Content Saved Succefully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Content Saved failed Error: ' . $th->getMessage());
        }
    }

    public function witnesses()
    {
        $witness = WitnessesPage::find(1);
        if ($witness) {
            $witness->w_img = $witness->w_img ? asset('storage/images/witnesses/' . $witness->w_img) : '';
        }
        return view('admin.common.witnesses', compact('witness'));
    }

    public function witnessesStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $w = WitnessesPage::find(1) ?? new WitnessesPage();
            $w->w_desc_one = $request->w_desc_one ? preg_replace('/[^\x20-\x7E]/u', '', $request->w_desc_one) : $w->w_desc_one;
            $w->w_desc_two = $request->w_desc_two ? preg_replace('/[^\x20-\x7E]/u', '', $request->w_desc_two) : $w->w_desc_two;
            $w->w_desc_three = $request->w_desc_three ? preg_replace('/[^\x20-\x7E]/u', '', $request->w_desc_three) : $w->w_desc_three;

            // /** Upload Path */
            $destinationPath = public_path('storage/images/witnesses/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Protection Work
            if ($request->hasFile('w_img')) {
                $file = $request->file('w_img');
                $protectWorkImgFour = 'w_img_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($w->w_img)) {
                    $oldFilePath = $destinationPath . $w->w_img;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $protectWorkImgFour);

                $w->w_img = $protectWorkImgFour;
            }

            $w->save();

            DB::commit();
            return back()->with('success', 'Content Saved Succefully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Content Saved failed Error: ' . $th->getMessage());
        }
    }
}
