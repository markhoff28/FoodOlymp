<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\AdminRestPasswordController;
use App\Http\Controllers\Admin\AdminChangePasswordController;

use App\Http\Controllers\Backend\AdminProductController;
use App\Http\Controllers\Backend\AdminReportController;
use App\Http\Controllers\Backend\AdminReviewController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\RestaurantController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\PermissionController;

use App\Http\Controllers\Client\ClientProfilController;
use App\Http\Controllers\Client\ClientChangePasswordController;
use App\Http\Controllers\Client\Backend\ClientOrderController;
use App\Http\Controllers\Client\Backend\CouponController;
use App\Http\Controllers\Client\Backend\GalleryController;
use App\Http\Controllers\Client\Backend\MenuController;
use App\Http\Controllers\Client\Backend\ProductController;
use App\Http\Controllers\Client\Backend\ReportController;
use App\Http\Controllers\Client\Backend\RestaurantReviewController;

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FilterController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\User\UserChangePasswordController;
use App\Http\Controllers\Frontend\User\UserOrderController;
use App\Http\Controllers\Frontend\User\UserWishlistController;

use App\Http\Controllers\Payment\CashOnDeliveryController;
use App\Http\Controllers\Payment\StripeController;

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

    // User Order All Routes
    Route::controller(UserOrderController::class)->group(function () {
        Route::get('/user/order/list', 'UserOrderList')->name('user.order.list');
        Route::get('/user/order/details/{id}', 'UserOrderDetails')->name('user.order.details');
        Route::get('/user/invoice/download/{id}', 'UserInvoiceDownload')->name('user.invoice.download');
    });
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
        Route::get('/all/category', 'AllCategory')->name('all.category')->middleware(['permission:category.all']);
        Route::get('/add/category', 'AddCategory')->name('add.category')->middleware('permission:category.add');
        Route::post('/store/category', 'StoreCategory')->name('store.category')->middleware('permission:category.add');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category')->middleware('permission:category.edit');
        Route::post('/update/category', 'UpdateCategory')->name('update.category')->middleware('permission:category.edit');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category')->middleware('permission:category.delete');
    });

    // City All Route 
    Route::controller(CityController::class)->group(function () {
        Route::get('/all/city', 'AllCity')->name('all.city')->middleware(['permission:city.all']);
        Route::post('/store/city', 'StoreCity')->name('city.store')->middleware(['permission:city.add']);
        Route::post('/store/city', 'StoreCity')->name('city.store')->middleware(['permission:city.add']);
        Route::get('/edit/city/{id}', 'EditCity')->middleware(['permission:city.edit']);
        Route::post('/update/city', 'UpdateCity')->name('city.update')->middleware(['permission:city.edit']);
        Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city')->middleware(['permission:city.delete']);
    });

    // Product All Route 
    Route::controller(AdminProductController::class)->group(function () {
        Route::get('/admin/all/product', 'AdminAllProduct')->name('admin.all.product')->middleware(['permission:product.all']);
        Route::get('/admin/add/product', 'AdminAddProduct')->name('admin.add.product')->middleware(['permission:product.add']);
        Route::post('/admin/store/product', 'AdminStoreProduct')->name('admin.product.store')->middleware(['permission:product.add']);
        Route::get('/admin/edit/product/{id}', 'AdminEditProduct')->name('admin.edit.product')->middleware(['permission:product.edit']);
        Route::post('/admin/update/product', 'AdminUpdateProduct')->name('admin.product.update')->middleware(['permission:product.edit']);
        Route::get('/admin/delete/product/{id}', 'AdminDeleteProduct')->name('admin.delete.product')->middleware(['permission:product.delete']);
        Route::get('/adminChangeStatus', 'AdminChangeStatus')->middleware(['permission:product.status']);
    });

    // Restaurant All Route
    Route::controller(RestaurantController::class)->group(function () {
        Route::get('/pending/restaurant', 'PendingRestaurant')->name('pending.restaurant')->middleware(['permission:restaurant.menu']);
        Route::get('/clientChangeStatus', 'ClientChangeStatus')->middleware(['permission:restaurant.status']);
        Route::get('/approve/restaurant', 'ApproveRestaurant')->name('approve.restaurant')->middleware(['permission:restaurant.menu']);
    });

    // Bannewr All Route
    Route::controller(BannerController::class)->group(function () {
        Route::get('/all/banner', 'AllBanner')->name('all.banner')->middleware(['permission:banner.all']);
        Route::post('/banner/store', 'BannerStore')->name('banner.store')->middleware(['permission:banner.add']);
        Route::get('/edit/banner/{id}', 'EditBanner')->middleware(['permission:banner.edit']);
        Route::post('/banner/update', 'BannerUpdate')->name('banner.update')->middleware(['permission:banner.edit']);
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner')->middleware(['permission:banner.delete']);
    });

    // Admin All Order Route 
    Route::controller(OrderController::class)->group(function () {
        Route::get('/pending/order', 'PendingOrder')->name('pending.order')->middleware(['permission:order.all']);
        Route::get('/admin/order/details/{id}', 'AdminOrderDetails')->name('admin.order.details')->middleware(['permission:order.all']);
        Route::get('/confirm/order', 'ConfirmOrder')->name('confirm.order')->middleware(['permission:order.all']);
        Route::get('/processing/order', 'ProcessingOrder')->name('processing.order')->middleware(['permission:order.all']);
        Route::get('/deliverd/order', 'DeliverdOrder')->name('deliverd.order')->middleware(['permission:order.all']);

        // Update order status
        Route::get('/pening_to_confirm/{id}', 'PendingToConfirm')->name('pening_to_confirm')->middleware(['permission:order.all']);
        Route::get('/confirm_to_processing/{id}', 'ConfirmToProcessing')->name('confirm_to_processing')->middleware(['permission:order.all']);
        Route::get('/processing_to_deliverd/{id}', 'ProcessingToDiliverd')->name('processing_to_deliverd')->middleware(['permission:order.all']);
    });

    Route::controller(AdminReportController::class)->group(function () {
        Route::get('/admin/all/reports', 'AminAllReports')->name('admin.all.reports')->middleware('permission:report.menu');
        Route::post('/admin/search/bydate', 'AminSearchByDate')->name('admin.search.bydate')->middleware('permission:report.menu');
        Route::post('/admin/search/bymonth', 'AminSearchByMonth')->name('admin.search.bymonth')->middleware('permission:report.menu');
        Route::post('/admin/search/byyear', 'AminSearchByYear')->name('admin.search.byyear')->middleware('permission:report.menu');
    });

    Route::controller(AdminReviewController::class)->group(function () {
        Route::get('/admin/pending/review', 'AdminPendingReview')->name('admin.pending.review')->middleware('permission:review.pending');
        Route::get('/admin/approve/review', 'AdminApproveReview')->name('admin.approve.review')->middleware('permission:review.approve');
        Route::get('/reviewchangeStatus', 'ReviewChangeStatus')->middleware('permission:review.menu');
    });

    // Mark notification as read
    Route::post('/mark-notification-as-read-admin/{notification}', [NotificationController::class, 'MarkAsRead']);

    // Permission All Route 
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('permission:role.permission.menu');
        Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('permission:role.permission.menu');
        Route::post('/store/permission', 'StorePermission')->name('store.permission')->middleware('permission:role.permission.menu');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('permission:role.permission.menu');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission')->middleware('permission:role.permission.menu');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('permission:role.permission.menu');
        Route::get('/import/permission', 'ImportPermission')->name('import.permission')->middleware('permission:role.permission.menu');
        Route::get('/export', 'Export')->name('export')->middleware('permission:role.permission.menu');
        Route::post('/import', 'Import')->name('import')->middleware('permission:role.permission.menu');
    });

    // Role All Route 
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles')->middleware('permission:role.permission.menu');
        Route::get('/add/roles', 'AddRoles')->name('add.roles')->middleware('permission:role.permission.menu');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles')->middleware('permission:role.permission.menu');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles')->middleware('permission:role.permission.menu');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles')->middleware('permission:role.permission.menu');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles')->middleware('permission:role.permission.menu');
    });

    // Role and Permissions All Route 
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('permission:role.permission.menu');
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('permission:role.permission.menu');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store')->middleware('permission:role.permission.menu');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles')->middleware('permission:role.permission.menu');
        Route::post('/admin/roles/update/{id}', 'AdminUpdateRoles')->name('admin.roles.update')->middleware('permission:role.permission.menu');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles')->middleware('permission:role.permission.menu');
    });

    // Admin User All Route 
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('user.management.menu');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('user.management.menu');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin')->middleware('user.management.menu');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('user.management.menu');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin')->middleware('user.management.menu');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('user.management.menu');
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

    // Client All Order Route 
    Route::controller(ClientOrderController::class)->group(function () {
        Route::get('/all/client/orders', 'AllClientOrders')->name('all.client.orders');
        Route::get('/client/order/details/{id}', 'ClientOrderDetails')->name('client.order.details');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/client/all/reports', 'ClientAllReports')->name('client.all.reports');
        Route::post('/client/search/bydate', 'ClientSearchByDate')->name('client.search.bydate');
        Route::post('/client/search/bymonth', 'ClientSearchByMonth')->name('client.search.bymonth');
        Route::post('/client/search/byyear', 'ClientSearchByYear')->name('client.search.byyear');
    });

    Route::controller(RestaurantReviewController::class)->group(function () {
        Route::get('/client/all/reviews', 'ClientAllReviews')->name('client.all.reviews');
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

Route::controller(CashOnDeliveryController::class)->group(function () {
    Route::post('/cash_order', 'CashOrder')->name('cash_order');
});

Route::controller(StripeController::class)->group(function () {
    Route::post('/stripe_order', 'StripeOrder')->name('stripe_order');
});

// Review
Route::controller(ReviewController::class)->group(function () {
    Route::post('/store/review', 'StoreReview')->name('store.review');
});

// Filter
Route::controller(FilterController::class)->group(function () {
    Route::get('/list/restaurant', 'ListRestaurant')->name('list.restaurant');
    Route::get('/filter/products', 'FilterProducts')->name('filter.products');
});
