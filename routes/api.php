<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Product Category
    Route::post('product-categories/media', 'ProductCategoryApiController@storeMedia')->name('product-categories.storeMedia');
    Route::apiResource('product-categories', 'ProductCategoryApiController');

    // Product
    Route::post('products/media', 'ProductApiController@storeMedia')->name('products.storeMedia');
    Route::apiResource('products', 'ProductApiController');

    // Product Status
    Route::apiResource('product-statuses', 'ProductStatusApiController');

    // Product Ajax
    Route::post('product-ajaxis/media', 'ProductAjaxApiController@storeMedia')->name('product-ajaxis.storeMedia');
    Route::apiResource('product-ajaxis', 'ProductAjaxApiController');

    // Supplier
    Route::post('suppliers/media', 'SupplierApiController@storeMedia')->name('suppliers.storeMedia');
    Route::apiResource('suppliers', 'SupplierApiController');

    // Expense
    Route::post('expenses/media', 'ExpenseApiController@storeMedia')->name('expenses.storeMedia');
    Route::apiResource('expenses', 'ExpenseApiController');

    // Purchase
    Route::post('purchases/media', 'PurchaseApiController@storeMedia')->name('purchases.storeMedia');
    Route::apiResource('purchases', 'PurchaseApiController');

    // Return Purchase
    Route::post('return-purchases/media', 'ReturnPurchaseApiController@storeMedia')->name('return-purchases.storeMedia');
    Route::apiResource('return-purchases', 'ReturnPurchaseApiController');

    // Damage Purchase
    Route::post('damage-purchases/media', 'DamagePurchaseApiController@storeMedia')->name('damage-purchases.storeMedia');
    Route::apiResource('damage-purchases', 'DamagePurchaseApiController');
});
