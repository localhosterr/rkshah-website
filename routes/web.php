<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CmsController;

// ── PUBLIC WEBSITE
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('fleet')->name('fleet.')->group(function(){
    Route::get('/',[FleetController::class,'index'])->name('index');
    Route::get('/{slug}',[FleetController::class,'show'])->name('show');
});
Route::prefix('routes')->name('routes.')->group(function(){
    Route::get('/',[RouteController::class,'index'])->name('index');
    Route::get('/{slug}',[RouteController::class,'show'])->name('show');
});
Route::prefix('packages')->name('packages.')->group(function(){
    Route::get('/',[PackageController::class,'index'])->name('index');
    Route::get('/{slug}',[PackageController::class,'show'])->name('show');
});
Route::prefix('blog')->name('blog.')->group(function(){
    Route::get('/',[BlogController::class,'index'])->name('index');
    Route::get('/{slug}',[BlogController::class,'show'])->name('show');
});
Route::get('/about',    [PageController::class,'about'])->name('about');
Route::get('/faq',      [PageController::class,'faq'])->name('faq');
Route::get('/contact',  [PageController::class,'contact'])->name('contact');
Route::get('/thank-you',[PageController::class,'thankYou'])->name('thank-you');
Route::post('/book',    [LeadController::class,'store'])->name('lead.store');
Route::get('/api/fare', [HomeController::class,'calculateFare'])->name('api.fare');

// ── CMS ADMIN
Route::prefix('cms')->name('cms.')->group(function(){

    // Auth
    Route::get('/login',  [CmsController::class,'loginForm'])->name('login');
    Route::post('/login', [CmsController::class,'loginPost'])->name('login.post');
    Route::get('/logout', [CmsController::class,'logout'])->name('logout');

    // Dashboard
    Route::get('/',          [CmsController::class,'dashboard'])->name('dashboard');
    Route::get('/dashboard', [CmsController::class,'dashboard']);

    // Leads
    Route::get('/leads',               [CmsController::class,'leads'])->name('leads');
    Route::get('/leads/{id}',          [CmsController::class,'leadShow'])->name('leads.show');
    Route::patch('/leads/{id}',        [CmsController::class,'leadUpdate'])->name('leads.update');
    Route::patch('/leads/{id}/status', [CmsController::class,'leadStatusUpdate'])->name('leads.status');
    Route::post('/leads/{id}/notes',   [CmsController::class,'leadNote'])->name('leads.note');

    // Bookings
    Route::get('/bookings',        [CmsController::class,'bookings'])->name('bookings');
    Route::get('/bookings/create', [CmsController::class,'bookingCreate'])->name('bookings.create');
    Route::post('/bookings',       [CmsController::class,'bookingStore'])->name('bookings.store');
    Route::get('/bookings/{id}',   [CmsController::class,'bookingShow'])->name('bookings.show');
    Route::patch('/bookings/{id}', [CmsController::class,'bookingUpdate'])->name('bookings.update');
    Route::get('/calendar',        [CmsController::class,'calendar'])->name('calendar');

    // Fleet — full CRUD
    Route::get('/fleet',          [CmsController::class,'fleet'])->name('fleet');
    Route::post('/fleet',         [CmsController::class,'fleetStore'])->name('fleet.store');
    Route::patch('/fleet/{id}',   [CmsController::class,'fleetUpdate'])->name('fleet.update');
    Route::delete('/fleet/{id}',  [CmsController::class,'fleetDelete'])->name('fleet.delete');

    // Routes — full CRUD
    Route::get('/routes',                    [CmsController::class,'routes'])->name('routes');
    Route::post('/routes',                   [CmsController::class,'routeStore'])->name('routes.store');
    Route::patch('/routes/{id}',             [CmsController::class,'routeUpdate'])->name('routes.update');
    Route::delete('/routes/{id}',            [CmsController::class,'routeDelete'])->name('routes.delete');
    Route::patch('/routes/{slug}/toggle',    [CmsController::class,'routeToggle'])->name('routes.toggle');

    // Content editors
    Route::get('/content/homepage',          [CmsController::class,'homepageEditor'])->name('content.homepage');
    Route::put('/content/homepage',          [CmsController::class,'homepageUpdate'])->name('content.homepage.update');
    Route::get('/content/about',             [CmsController::class,'aboutEditor'])->name('content.about');
    Route::put('/content/about',             [CmsController::class,'aboutUpdate'])->name('content.about.update');
    Route::post('/content/timeline',         [CmsController::class,'timelineStore'])->name('content.timeline.store');
    Route::delete('/content/timeline/{id}',  [CmsController::class,'timelineDelete'])->name('content.timeline.delete');

    // Packages — full CRUD
    Route::get('/content/packages',          [CmsController::class,'packages'])->name('content.packages');
    Route::post('/content/packages',         [CmsController::class,'packageStore'])->name('content.packages.store');
    Route::patch('/content/packages/{id}',   [CmsController::class,'packageUpdate'])->name('content.packages.update');
    Route::delete('/content/packages/{id}',  [CmsController::class,'packageDelete'])->name('content.packages.delete');

    // Testimonials
    Route::get('/testimonials',              [CmsController::class,'testimonials'])->name('testimonials');
    Route::post('/testimonials',             [CmsController::class,'testimonialStore'])->name('testimonials.store');
    Route::patch('/testimonials/{id}',       [CmsController::class,'testimonialUpdate'])->name('testimonials.update');
    Route::delete('/testimonials/{id}',      [CmsController::class,'testimonialDelete'])->name('testimonials.delete');

    // Blog
    Route::get('/blog',                      [CmsController::class,'blog'])->name('blog');
    Route::get('/blog/create',               [CmsController::class,'blogCreate'])->name('blog.create');
    Route::post('/blog',                     [CmsController::class,'blogStore'])->name('blog.store');
    Route::get('/blog/{slug}/edit',          [CmsController::class,'blogEdit'])->name('blog.edit');
    Route::patch('/blog/{slug}',             [CmsController::class,'blogUpdate'])->name('blog.update');
    Route::delete('/blog/{slug}',            [CmsController::class,'blogDelete'])->name('blog.delete');

    // FAQ
    Route::get('/faqs',                      [CmsController::class,'faqs'])->name('faqs');
    Route::post('/faqs',                     [CmsController::class,'faqStore'])->name('faqs.store');
    Route::patch('/faqs/{id}',               [CmsController::class,'faqUpdate'])->name('faqs.update');
    Route::delete('/faqs/{id}',              [CmsController::class,'faqDelete'])->name('faqs.delete');

    // Media
    Route::get('/media',                     [CmsController::class,'media'])->name('media');
    Route::post('/media/upload',             [CmsController::class,'mediaUpload'])->name('media.upload');
    Route::delete('/media/{filename}',       [CmsController::class,'mediaDelete'])->name('media.delete');

    // Settings
    Route::get('/settings',                  [CmsController::class,'settings'])->name('settings');
    Route::put('/settings',                  [CmsController::class,'settingsUpdate'])->name('settings.update');
    Route::post('/settings/password', [CmsController::class,'changePassword'])->name('settings.password');

    // Global search
    Route::get('/search', [CmsController::class,'globalSearch'])->name('search');

});
