<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginRegController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\B2BController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ABLAccountsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NagadController;
use App\Http\Controllers\PaymentNagadController;


Route::get('testCopyImage',[ProductController::class,'testCopyImage']);

Route::get('store-reg-form',[LoginRegController::class,'regForm'])->name('store-reg-form');
Route::post('store-reg',[LoginRegController::class,'storeReg'])->name('store-reg');


Route::get('store-login-form',[LoginRegController::class,'loginForm'])->name('store-login-form');
Route::post('store-login',[LoginRegController::class,'storeLogin'])->name('store-login');
Route::get('store-logout',[LoginRegController::class,'storeLogout'])->name('store-logout');

//regPayment
Route::get('/registration/payment/{id}', [PaymentNagadController::class,'RegPayment'])->name('reg.payment');
Route::get('/registration/paid/{requiredData}', [PaymentNagadController::class,'RegPaid'])->name('reg.callback');

//AblComissionPayment
Route::get('/ablcomission/payment/{storeId}', [PaymentNagadController::class,'AblComPayment'])->name('abl.com.payment');
Route::get('/ablcomission/paid/{invoices}/{requiredData}', [PaymentNagadController::class,'AblComPaid'])->name('abl.com.callback');

//B2B Order Payment
Route::get('/b2border/payment/{inv}', [PaymentNagadController::class,'B2BOrderPayment'])->name('b2b.order.payment');
Route::get('/b2border/paid/{invoice}/{requiredData}', [PaymentNagadController::class,'B2BOrderPaid'])->name('b2b.order.callback');


//nagad
Route::get('/nagad/callback/{redirectURL}', [NagadController::class,'callback'])->name('nagad.callback');
Route::get('/nagad/payment/{redirectUrl}/{sensitiveData}', [NagadController::class,'checkout'])->name('nagad.checkout');


Route::group(['middleware'=>['StoreLoginCheck']],function(){

    Route::get('/',[HomeController::class,'dashboard'])->name('dashboard');

    //own product
    Route::get('upload-own-product-form',[ProductController::class,'ownProductFrom'])->name('upload-own-product-form');
    Route::post('insert-own-product',[ProductController::class,'insertOwnProduct'])->name('insert-own-product');
    Route::get('own-product-list',[ProductController::class,'ownProductList'])->name('own-product-list');
    Route::get('edit-own-product-form/{product_id}',[ProductController::class,'ownProductEditFrom'])->name('edit-own-product-form');
    Route::post('edit-own-product',[ProductController::class,'editOwnProduct'])->name('edit-own-product');
    Route::get('mrp-change-request',[ProductController::class,'ChangeMRP'])->name('mrp-change-request');
    Route::get('changeable-mrp-product-list',[ProductController::class,'C_MRP_List'])->name('changeable-mrp-product-list');
    Route::post('insert-change-mrp-value',[ProductController::class,'insertNewMRP'])->name('insert-change-mrp-value');
    Route::get('changeable-mrp-product-list/load-product/{lastID}/{dataCount}',[ProductController::class,'C_MRP_List_Load'])->name('changeable-mrp-product-list/load-product/');
    
    //add from amardokan
    Route::get('amardokan-product-for-add',[ProductController::class,'amarDokanProductForAdd'])->name('amardokan-product-for-add');
    Route::get('amardokan-product-for-add/load-product/{lastID}',[ProductController::class,'addFromAmarDokanLoadProduct'])->name('add-from-AD-load-product');
    Route::post('add-product-from-amardokan',[ProductController::class,'AddFromAmarDokan'])->name('add-product-from-amardokan');
    Route::get('amardokan-product-details-view/{product_id}',[ProductController::class,'amarDokanproductDetails'])->name('amardokan-product-details-view');

    //category
    Route::get('get-sub-category/{category_id}',[ProductController::class,'getSubCategory'])->name('get-sub-category');

    //my product list
    Route::get('my-product-list',[ProductController::class,'MyProductList'])->name('my-product-list');
    Route::get('my-product-list/loadProduct/{lastId}/{dataCount}',[ProductController::class,'LoadProductList'])->name('load-product-list');
    Route::get('enlist-store-proudct/{store_p_id}/{enlist}',[ProductController::class,'enlistStoreProduct'])->name('enlist-store-proudct');
    Route::post('store-stock-update',[ProductController::class,'storeStockUpdate'])->name('store-stock-update');
    Route::post('edit-my-shop-product-info',[ProductController::class,'editMyShopProductInfo'])->name('edit-my-shop-product-info');

    //shop live product
    Route::get('shop-live-products',[ProductController::class,'ShopLiveProductList'])->name('shop-live-products');

    //campaigns
    Route::get('campaign-required-product-list/{campaign_name}',[CampaignController::class,'ReqProductList'])->name('campaign-req-product-list');
    Route::get('add-or-remove-from-campaign/{store_p_id}/{type}/{campaign_name}',[CampaignController::class,'addOrRemove'])->name('add-or-remove-from-campaign');

    Route::get('special-combo-offer',[CampaignController::class,'ComboOfferList'])->name('campaign-special-combo');
    Route::get('discount-offer',[CampaignController::class,'DiscountOfferList'])->name('campaign-discount');
    Route::get('seller-campaign',[CampaignController::class,'SellerCampaignList'])->name('seller-campaign');


    //Purchase from admin

    //b2b new product
    Route::get('b2b-new-arrival',[B2BController::class,'NewArrival'])->name('b2b-new-arrival');
    Route::get('b2b-product-details-view/{product_id}',[B2BController::class,'productDetails'])->name('b2b-product-details-view');

    //b2b cart
    Route::post('b2b-add-to-cart',[B2BController::class,'addToCart'])->name('b2b-add-to-cart');
    Route::get('show-b2b-cart',[B2BController::class,'showCart'])->name('show-b2b-cart');
    Route::post('update-b2b-cart',[B2BController::class,'updateB2bCart'])->name('update-b2b-cart');
    Route::post('remove-from-b2b-cart',[B2BController::class,'removeB2bCart'])->name('remove-from-b2b-cart');

    //b2b order
    Route::post('confirm-b2b-order',[B2BController::class,'confirmOrder'])->name('confirm-b2b-order');
    Route::get('b2b-order-list',[B2BController::class,'OrderList'])->name('b2b-order-list');
    Route::get('b2b-order-invoice/{invoice}',[B2BController::class,'showInvoice'])->name('b2b-order-invoice');

    //For suppplier wise product
    Route::get('b2b-all-suppliers',[B2BController::class,'AllSuppliers'])->name('b2b-all-suppliers');

    Route::get('b2b-suppliers-product/{suppplier_id}',[B2BController::class,'supllierProduct'])->name('b2b-suppliers-product');

    //Customer Orders
    Route::get('order-list',[OrdersController::class,'AllOrders'])->name('order-list');
    Route::get('show-gen-invoice/{invoice}',[OrdersController::class,'showGenInvoice'])->name('show-gen-invoice');
    Route::post('update-gen-order-status',[OrdersController::class,'updateGenStatus'])->name('update-gen-order-status');
    Route::get('pending-list',[OrdersController::class,'PendingOrders'])->name('pending-list');
    Route::get('delivered-list',[OrdersController::class,'DeliveredOrders'])->name('delivered-list');
    Route::get('processing-list',[OrdersController::class,'ProcessingOrders'])->name('processing-list');
    Route::get('canceled-list',[OrdersController::class,'CanceledOrders'])->name('canceled-list');

    //customer
    Route::get('customer-list',[CustomerController::class,'AllCustomer'])->name('customer-list');
    Route::get('customer-reg-form',[CustomerController::class,'regForm'])->name('customer-reg-form');
    Route::post('customer-reg',[CustomerController::class,'customerReg'])->name('customer-reg');
    Route::get('all-customer-list',[CustomerController::class,'AllCustomerList'])->name('all-customer-list');



    //accounting
    Route::get('my-accounts',[AccountsController::class,'MyAccounts'])->name('accounts');
    Route::post('daily-acc_transection',[AccountsController::class,'acc_transection'])->name('daily-acc_transection');

    // amardokan accounts
    Route::get('abl-accounts-payable-to-abl',[ABLAccountsController::class,'PayableToABL'])->name('payable-to-abl');
    Route::get('abl-accounts-paidList',[ABLAccountsController::class,'PaidList'])->name('paid-list');

    //support
    Route::get('support',[SupportController::class,'Index'])->name('support');
    Route::post('create-issue',[SupportController::class,'createIssue'])->name('create-issue');
    Route::get('support-details/{issue_id}',[SupportController::class,'Details'])->name('support-details');

    //profile
    Route::get('profile-edit',[ProfileController::class,'index'])->name('profile-edit');
    Route::post('store-profile-update',[ProfileController::class,'update'])->name('store-profile-update');

    //search on product
    Route::get('search-shop-live-product',[SearchController::class,'shopLiveProduct'])->name('search-shop-live-product');
    Route::get('search-my-product-list',[SearchController::class,'myProductList'])->name('search-my-product-list');
    Route::get('search-amardokan-product-for-add',[SearchController::class,'amarDokanProductForAdd'])->name('search-amardokan-product-for-add');
    Route::get('search-changelist-mrp',[SearchController::class,'changeMRP'])->name('search-changelist-mrp');
    Route::get('search-changeable-mrp-product-list',[SearchController::class,'C_MRP_List'])->name('search-changeable-mrp-product-list');
    
    //search on campain
    Route::get('search-special-combo-offer',[SearchController::class,'ComboOfferList'])->name('search-special-combo-offer');
    Route::get('search-discount-offer',[SearchController::class,'DiscountOfferList'])->name('search-discount-offer');
    Route::get('search-seller-campaign',[SearchController::class,'SellerCampaignList'])->name('search-seller-campaign');
    Route::get('search-campaign-required-product-list/{campaign_name}',[SearchController::class,'ReqProductList'])->name('search-campaign-required-product-list');


    //seach purchase from admin
    Route::get('search-b2b-new-arrival',[SearchController::class,'NewArrival'])->name('search-b2b-new-arrival');
    Route::get('search-b2b-all-suppliers',[SearchController::class,'AllSuppliers'])->name('search-b2b-all-suppliers');
    Route::get('search-b2b-suppliers-product/{suppplier_id}',[SearchController::class,'supllierProduct'])->name('search-b2b-suppliers-product');


    //notification
    Route::get('view-all-notification',[NotificationController::class,'showAll'])->name('view-all-notification');
    Route::get('show-full-notification/{id}',[NotificationController::class,'showFull'])->name('show-full-notification');
    
    //Delivery Service
    Route::get('create-delivery-man',[SupportController::class,'CreateDeliveryMan'])->name('create-delivery-man');
    Route::get('delivery-man-list',[SupportController::class,'DeliveryManList'])->name('delivery-man-list');
    Route::get('all-delivery-man-list',[SupportController::class,'AllDeliveryManList'])->name('all-delivery-man-list');
    Route::post('insert-delivery-man',[SupportController::class,'InsertDeliveryMan'])->name('insert-delivery-man');
});



Route::get('testNagad',[TestNagadController::class,'index']);

Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode2 = Artisan::call('view:clear');
    // return what you want
});

