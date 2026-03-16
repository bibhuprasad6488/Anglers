<?php

use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CmsContactpageController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\PropertyCategoryController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ResourcesController;
use App\Http\Controllers\Admin\SettingController;
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

        Route::get('all-pages', [SettingController::class, 'viewAllPages'])->name('all-page');

        // Home Page
        Route::resource('home-page-setting', HomepageController::class)->names('home-page-setting');
        // Contact Page
        Route::resource('contact-page-setting', CmsContactpageController::class)->names('contact-page-setting');
        // Resources Page
        Route::resource('resources-page-setting', ResourcesController::class)->names('resources-page-setting');
        // Gallery Page
        Route::resource('gallery-page-setting', GalleryController::class)->names('gallery-page-setting');
        // Posts
        Route::resource('posts', BlogPostController::class)->names('posts');
        // Property Category
        Route::resource('property-categories', PropertyCategoryController::class)->names('property-categories');
        Route::get('add-property/{id}', [PropertyCategoryController::class, 'addProperty'])->name('add-property');
        Route::get('edit-property/{id}', [PropertyCategoryController::class, 'editProperty'])->name('edit-property');
        Route::get('view-properties/{id}', [PropertyCategoryController::class, 'viewProperties'])->name('view-properties');
        // Properties
        Route::resource('properties', PropertyController::class)->names('properties');
        Route::get('del-property-img/{id}', [PropertyController::class, 'deletePropertyImage'])->name('del-property-img');

        // Setting
        Route::resource('profile-setting', SettingController::class)->names('profile-setting');
        Route::post('chnage-password/{id}', [SettingController::class, 'chnagePassword'])->name('chnage-password');
        Route::get('/settings', [SettingController::class, 'siteSetting'])->name('site.setting');
        Route::post('/update-settings', [SettingController::class, 'updateSiteSetting'])->name('update.site.setting');
        Route::get('/contact-requests', [SettingController::class, 'contactRequests'])->name('contact.request');
        Route::post('/access-change', [SettingController::class, 'chnageAccess'])->name('change.access');
        Route::get('/privacy-policy', [SettingController::class, 'privacyPolicy'])->name('privacy.policy');
        Route::post('/privacy-policy-store', [SettingController::class, 'privacyPolicyStore'])->name('privacy.policy.store');
        Route::get('/terms-of-business', [SettingController::class, 'termOfBusiness'])->name('term.business');
        Route::post('/terms-of-business-store', [SettingController::class, 'termOfBusinessStore'])->name('term.business.store');
    });
});

// Route::middleware(['auth:web'])->group(function () {
//     // User protected routes
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/resources', [HomeController::class, 'resourcesPageDetails'])->name('resources');
Route::get('/gallery', [HomeController::class, 'galleryPageDetails'])->name('gallery');
Route::get('/blog', [HomeController::class, 'blogLists'])->name('blogs');
Route::get('/blog-details/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/category/{slug}', [HomeController::class, 'catProperties'])->name('category.properties');
Route::get('/accommodation/{slug}', [HomeController::class, 'propertyDetails'])->name('property.details');
Route::get('/search-result', [HomeController::class, 'searchFormResult'])->name('search.result');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact');
Route::post('/contact-us-submit', [HomeController::class, 'contactUsStore'])->name('contact.submit');
Route::get('/thank-you', [HomeController::class, 'thankYou'])->name('thank-you');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms-of-business', [HomeController::class, 'termsOfBusiness'])->name('terms.business');
