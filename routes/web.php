<?php

use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InsightController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/optimize', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    return 'Command executed successfully!';
    // return what you want
});



Route::get('/login', function () {
    return redirect()->route('admin.login');
    // return "ok";
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

    // Route::get('/forget-password', [App\Http\Controllers\Admin\Auth\LoginController::class, 'forgetPassword'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Admin\Auth\LoginController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function (Request $request, $token) {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'request' => $request
        ]);
    })->name('password.reset');

    Route::post('/reset-password', [App\Http\Controllers\Admin\Auth\LoginController::class, 'reset'])->name('password.store');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Partners
        Route::resource('partners', PartnerController::class)->names('partners');
        // Topics
        Route::resource('topics', TopicController::class)->names('topics');
        // Price Categories
        Route::resource('price-categories', CategoryController::class)->names('price-categories');
        // Pricing
        Route::resource('pricings', PricingController::class)->names('pricings');
        // Packages
        Route::resource('packages', PackageController::class)->names('packages');
        // Case Studies
        Route::resource('case-studies', CaseStudyController::class)->names('case-studies');
        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->names('testimonials');
        // Services
        Route::resource('services', ServiceController::class)->names('services');
        // Setting
        Route::resource('profile-setting', SettingController::class)->names('profile-setting');
        Route::post('chnage-password/{id}', [SettingController::class, 'chnagePassword'])->name('chnage-password');
        Route::get('/settings', [SettingController::class, 'siteSetting'])->name('site.setting');
        Route::post('/update-settings', [SettingController::class, 'updateSiteSetting'])->name('update.site.setting');
        Route::get('/get-wills', [SettingController::class, 'getWills'])->name('wills.list');
        Route::get('/view-will/{id}', [SettingController::class, 'viewWill'])->name('wills.list.show');
        Route::get('/contact-requests', [SettingController::class, 'contactRequests'])->name('contact.request');
        Route::post('/access-change', [SettingController::class, 'chnageAccess'])->name('change.access');
        Route::get('/privacy-policy', [SettingController::class, 'privacyPolicy'])->name('privacy.policy');
        Route::post('/privacy-policy-store', [SettingController::class, 'privacyPolicyStore'])->name('privacy.policy.store');
        Route::get('/terms-of-business', [SettingController::class, 'termOfBusiness'])->name('term.business');
        Route::post('/terms-of-business-store', [SettingController::class, 'termOfBusinessStore'])->name('term.business.store');
        Route::get('/story', [SettingController::class, 'ourStory'])->name('our.story');
        Route::post('/story-store', [SettingController::class, 'ourStoryStore'])->name('our.story.store');
        Route::get('/guided-journey', [SettingController::class, 'guidedJourney'])->name('guided.journey');
        Route::post('/guided-journey-store', [SettingController::class, 'guidedJourneyStore'])->name('guided.journey.store');
        Route::get('/protect', [SettingController::class, 'protection'])->name('protect');
        Route::post('/protect-store', [SettingController::class, 'protectionStore'])->name('protect.store');
        Route::get('/witnesses', [SettingController::class, 'witnesses'])->name('witnesses');
        Route::post('/witnesses-store', [SettingController::class, 'witnessesStore'])->name('witnesses.store');
    });
});

// Route::middleware(['auth:web'])->group(function () {
//     // User protected routes
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'getServices'])->name('service.lists');
Route::get('/services/{slug}', [HomeController::class, 'serviceDetails'])->name('service.details');
Route::get('/guided-journey', [HomeController::class, 'guidedJourney'])->name('journey');
Route::get('/insights', [HomeController::class, 'blogLists'])->name('blogs');
Route::get('/insights/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/insights/category/{slug}', [HomeController::class, 'categoryBlogs'])->name('blog.category');
Route::get('/price-lists', [HomeController::class, 'priceLists'])->name('price-lists');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact');
Route::post('/contact-us-submit', [HomeController::class, 'contactUsStore'])->name('contact.submit');
Route::get('/start-your-will', [HomeController::class, 'startYourWills'])->name('start.will');
Route::post('/start-your-will-store', [HomeController::class, 'storeWills'])->name('start.will.submit');
Route::get('/thank-you', [HomeController::class, 'thankYou'])->name('thank-you');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms-of-business', [HomeController::class, 'termsOfBusiness'])->name('terms.business');
Route::get('/our-story', [HomeController::class, 'ourStory'])->name('story');
Route::get('/witnesses', [HomeController::class, 'witnesses'])->name('witness');
Route::get('/protection', [HomeController::class, 'protection'])->name('protection');
