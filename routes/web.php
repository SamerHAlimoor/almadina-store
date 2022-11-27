<?php

use App\Http\Controllers\Api\WeatherApiController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Front\AuthFortify\TwoFactorAuthentication;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConvertController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']

], function () {

    Route::get('/weather', [WeatherApiController::class, 'weather'])->name('weatherCity');

    Route::get('/',  [HomeController::class, 'index'])->name('home_page');
    Route::get('/product', [ProductsController::class, 'index'])
        ->name('product.index');
    Route::resource('cart', CartController::class);


    Route::get('/notification/{notification_id}', [NotificationController::class, 'setread'])->name('set.read');


    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
        ->name('orders.payments.create');

    Route::post('orders/{order}/stripe/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
        ->name('stripe.paymentIntent.create');



    Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
        ->name('stripe.return');

    Route::any('stripe/webhook', [StripeWebhookController::class, 'handle']);


    Route::get('/product/{product:slug}', [ProductsController::class, 'show'])
        ->name('product.show');
    Route::post('checkout/create-payment', [PaymentsController::class, 'store'])
        ->name('checkout.payment');
    Route::post('currency', [CurrencyConvertController::class, 'store'])
        ->name('currency.store');
    Route::get('auth/user/2fa', [TwoFactorAuthentication::class, 'index'])
        ->name('front.2fa');

    Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
        ->name('auth.socilaite.redirect');
    Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
        ->name('auth.socilaite.callback');

    Route::get('auth/{provider}/user', [SocialController::class, 'index']);

    Route::get('/orders/{order}', [OrdersController::class, 'show'])
        ->name('orders.show');
});
// require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';