<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\AdminRestPasswordController;
use App\Http\Controllers\Admin\AdminChangePasswordController;

use App\Http\Controllers\Backend\AdminProductController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\RestaurantController;

use App\Http\Controllers\Client\ClientProfilController;
use App\Http\Controllers\Client\ClientChangePasswordController;
use App\Http\Controllers\Client\Backend\CouponController;
use App\Http\Controllers\Client\Backend\GalleryController;
use App\Http\Controllers\Client\Backend\MenuController;
use App\Http\Controllers\Client\Backend\ProductController;

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\User\UserChangePasswordController;
use App\Http\Controllers\Frontend\User\UserWishlistController;

use App\Http\Controllers\Payment\CashOnDeliveryController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;

Route::get('/', [IndexController::class, 'Index'])->name('index');

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('frontend.dashboard.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    // Usee update password
    Route::get('/change/password', [UserChangePasswordController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/password/update', [UserChangePasswordController::class, 'UserPasswordUpdate'])->name('user.password.update');

    // Get Wishlist data for user 
    Route::get('/all/wishlist', [UserWishlistController::class, 'AllWishlist'])->name('all.wishlist');
    Route::get('/remove/wishlist/{id}', [UserWishlistController::class, 'RemoveWishlist'])->name('remove.wishlist');
});

require __DIR__ . '/auth.php';

// Admin Group Middleware 
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    // Admin manage profile data
    Route::get('/admin/profile', [AdminProfilController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminProfilController::class, 'AdminProfileStore'])->name('admin.profile.store');
    // Admin update password
    Route::get('/admin/change/password', [AdminChangePasswordController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminChangePasswordController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    // Category All Route 
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
    });

    // City All Route 
    Route::controller(CityController::class)->group(function () {
        Route::get('/all/city', 'AllCity')->name('all.city');
        Route::post('/store/city', 'StoreCity')->name('city.store');
        Route::post('/store/city', 'StoreCity')->name('city.store');
        Route::get('/edit/city/{id}', 'EditCity');
        Route::post('/update/city', 'UpdateCity')->name('city.update');
        Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');
    });

    // Product All Route 
    Route::controller(AdminProductController::class)->group(function () {
        Route::get('/admin/all/product', 'AdminAllProduct')->name('admin.all.product');
        Route::get('/admin/add/product', 'AdminAddProduct')->name('admin.add.product');
        Route::post('/admin/store/product', 'AdminStoreProduct')->name('admin.product.store');
        Route::get('/admin/edit/product/{id}', 'AdminEditProduct')->name('admin.edit.product');
        Route::post('/admin/update/product', 'AdminUpdateProduct')->name('admin.product.update');
        Route::get('/admin/delete/product/{id}', 'AdminDeleteProduct')->name('admin.delete.product');
        Route::get('/adminChangeStatus', 'AdminChangeStatus');
    });

    // Restaurant All Route
    Route::controller(RestaurantController::class)->group(function () {
        Route::get('/pending/restaurant', 'PendingRestaurant')->name('pending.restaurant');
        Route::get('/clientChangeStatus', 'ClientChangeStatus');
        Route::get('/approve/restaurant', 'ApproveRestaurant')->name('approve.restaurant');
    });

    // Restaurant All Route
    Route::controller(BannerController::class)->group(function () {
        Route::get('/all/banner', 'AllBanner')->name('all.banner');
        Route::post('/banner/store', 'BannerStore')->name('banner.store');
        Route::get('/edit/banner/{id}', 'EditBanner');
        Route::post('/banner/update', 'BannerUpdate')->name('banner.update');
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner');
    });
});
// End Admin Group Middleware 

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');

// Admin forget password
Route::get('/admin/forget-password', [AdminRestPasswordController::class, 'AdminForgetPassword'])->name('admin.forget-password');
Route::post('/admin/password-submit', [AdminRestPasswordController::class, 'AdminPasswordSubmit'])->name('admin.password-submit');
Route::get('/admin/reset-password/{token}/{email}', [AdminRestPasswordController::class, 'AdminResetPassword']);
Route::post('/admin/reset_password_submit', [AdminRestPasswordController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

// Client Group Group Middleware
Route::middleware('client', 'status')->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
    Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');
    // Client manage profile data
    Route::get('/client/profile', [ClientProfilController::class, 'ClientProfile'])->name('client.profile');
    Route::post('/client/profile/store', [ClientProfilController::class, 'ClientProfileStore'])->name('client.profile.store');
    // Client update password
    Route::get('/client/change/password', [ClientChangePasswordController::class, 'ClientChangePassword'])->name('client.change.password');
    Route::post('/client/password/update', [ClientChangePasswordController::class, 'ClientPasswordUpdate'])->name('client.password.update');

    // Menu All Route 
    Route::controller(MenuController::class)->group(function () {
        Route::get('/all/menu', 'AllMenu')->name('all.menu');
        Route::get('/add/menu', 'AddMenu')->name('add.menu');
        Route::post('/store/menu', 'StoreMenu')->name('menu.store');
        Route::get('/edit/menu/{id}', 'EditMenu')->name('edit.menu');
        Route::post('/update/menu', 'UpdateMenu')->name('menu.update');
        Route::get('/delete/menu/{id}', 'DeleteMenu')->name('delete.menu');
    });

    // Product All Route 
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('product.store');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/update/product', 'UpdateProduct')->name('product.update');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');
        Route::get('/changeStatus', 'ChangeStatus');
    });

    // Gallery All Route 
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('gallery.store');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/update/gallery', 'UpdateGallery')->name('gallery.update');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');
    });

    // Coupon All Route 
    Route::controller(CouponController::class)->group(function () {
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('coupon.store');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('coupon.update');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
    });
});
// End Client Group Group Middleware

// Route Accessable for All 
Route::get('/client/login', [ClientController::class, 'ClientLogin'])->name('client.login');
Route::get('/client/register', [ClientController::class, 'ClientRegister'])->name('client.register');
Route::post('/client/register/submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');
Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');

// Frontend Routes
Route::controller(IndexController::class)->group(function () {
    Route::get('/restaurant/details/{id}', 'RestaurantDetails')->name('res.details');
});

//
// Add to Wishlist 
Route::controller(WishlistController::class)->group(function () {
    Route::post('/add-wish-list/{id}', 'AddWishList');
});


// Cart routes

// Add to cart store data
Route::controller(CartController::class)->group(function () {
    Route::get('/add_to_cart/{id}', 'AddToCart')->name('add_to_cart');
    Route::post('/cart/update-quantity', 'updateCartQuanity')->name('cart.updateQuantity');
    Route::post('/cart/remove', 'CartRemove')->name('cart.remove');
    Route::post('/apply-coupon', 'ApplyCoupon');
    Route::get('/remove-coupon', 'CouponRemove');
});

// Checkout Page Route 
Route::get('/checkout', [CheckoutController::class, 'ShopCheckout'])->name('checkout');

Route::controller(CashOnDeliveryController::class)->group(function(){
    Route::post('/cash_order', 'CashOrder')->name('cash_order');
   
});
