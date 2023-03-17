<?php

Route::view('/', 'welcome');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::post('product-categories/parse-csv-import', 'ProductCategoryController@parseCsvImport')->name('product-categories.parseCsvImport');
    Route::post('product-categories/process-csv-import', 'ProductCategoryController@processCsvImport')->name('product-categories.processCsvImport');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::post('products/parse-csv-import', 'ProductController@parseCsvImport')->name('products.parseCsvImport');
    Route::post('products/process-csv-import', 'ProductController@processCsvImport')->name('products.processCsvImport');
    Route::resource('products', 'ProductController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Question
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Product Status
    Route::delete('product-statuses/destroy', 'ProductStatusController@massDestroy')->name('product-statuses.massDestroy');
    Route::post('product-statuses/parse-csv-import', 'ProductStatusController@parseCsvImport')->name('product-statuses.parseCsvImport');
    Route::post('product-statuses/process-csv-import', 'ProductStatusController@processCsvImport')->name('product-statuses.processCsvImport');
    Route::resource('product-statuses', 'ProductStatusController');

    // Product Ajax
    Route::delete('product-ajaxis/destroy', 'ProductAjaxController@massDestroy')->name('product-ajaxis.massDestroy');
    Route::post('product-ajaxis/media', 'ProductAjaxController@storeMedia')->name('product-ajaxis.storeMedia');
    Route::post('product-ajaxis/ckmedia', 'ProductAjaxController@storeCKEditorImages')->name('product-ajaxis.storeCKEditorImages');
    Route::post('product-ajaxis/parse-csv-import', 'ProductAjaxController@parseCsvImport')->name('product-ajaxis.parseCsvImport');
    Route::post('product-ajaxis/process-csv-import', 'ProductAjaxController@processCsvImport')->name('product-ajaxis.processCsvImport');
    Route::resource('product-ajaxis', 'ProductAjaxController');

    // Supplier
    Route::delete('suppliers/destroy', 'SupplierController@massDestroy')->name('suppliers.massDestroy');
    Route::post('suppliers/media', 'SupplierController@storeMedia')->name('suppliers.storeMedia');
    Route::post('suppliers/ckmedia', 'SupplierController@storeCKEditorImages')->name('suppliers.storeCKEditorImages');
    Route::post('suppliers/parse-csv-import', 'SupplierController@parseCsvImport')->name('suppliers.parseCsvImport');
    Route::post('suppliers/process-csv-import', 'SupplierController@processCsvImport')->name('suppliers.processCsvImport');
    Route::resource('suppliers', 'SupplierController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::post('expenses/media', 'ExpenseController@storeMedia')->name('expenses.storeMedia');
    Route::post('expenses/ckmedia', 'ExpenseController@storeCKEditorImages')->name('expenses.storeCKEditorImages');
    Route::post('expenses/parse-csv-import', 'ExpenseController@parseCsvImport')->name('expenses.parseCsvImport');
    Route::post('expenses/process-csv-import', 'ExpenseController@processCsvImport')->name('expenses.processCsvImport');
    Route::resource('expenses', 'ExpenseController');

    // Purchase
    Route::delete('purchases/destroy', 'PurchaseController@massDestroy')->name('purchases.massDestroy');
    Route::post('purchases/media', 'PurchaseController@storeMedia')->name('purchases.storeMedia');
    Route::post('purchases/ckmedia', 'PurchaseController@storeCKEditorImages')->name('purchases.storeCKEditorImages');
    Route::post('purchases/parse-csv-import', 'PurchaseController@parseCsvImport')->name('purchases.parseCsvImport');
    Route::post('purchases/process-csv-import', 'PurchaseController@processCsvImport')->name('purchases.processCsvImport');
    Route::resource('purchases', 'PurchaseController');

    // Return Purchase
    Route::delete('return-purchases/destroy', 'ReturnPurchaseController@massDestroy')->name('return-purchases.massDestroy');
    Route::post('return-purchases/media', 'ReturnPurchaseController@storeMedia')->name('return-purchases.storeMedia');
    Route::post('return-purchases/ckmedia', 'ReturnPurchaseController@storeCKEditorImages')->name('return-purchases.storeCKEditorImages');
    Route::post('return-purchases/parse-csv-import', 'ReturnPurchaseController@parseCsvImport')->name('return-purchases.parseCsvImport');
    Route::post('return-purchases/process-csv-import', 'ReturnPurchaseController@processCsvImport')->name('return-purchases.processCsvImport');
    Route::resource('return-purchases', 'ReturnPurchaseController');

    // Damage Purchase
    Route::delete('damage-purchases/destroy', 'DamagePurchaseController@massDestroy')->name('damage-purchases.massDestroy');
    Route::post('damage-purchases/media', 'DamagePurchaseController@storeMedia')->name('damage-purchases.storeMedia');
    Route::post('damage-purchases/ckmedia', 'DamagePurchaseController@storeCKEditorImages')->name('damage-purchases.storeCKEditorImages');
    Route::post('damage-purchases/parse-csv-import', 'DamagePurchaseController@parseCsvImport')->name('damage-purchases.parseCsvImport');
    Route::post('damage-purchases/process-csv-import', 'DamagePurchaseController@processCsvImport')->name('damage-purchases.processCsvImport');
    Route::resource('damage-purchases', 'DamagePurchaseController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Question
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Product Status
    Route::delete('product-statuses/destroy', 'ProductStatusController@massDestroy')->name('product-statuses.massDestroy');
    Route::resource('product-statuses', 'ProductStatusController');

    // Product Ajax
    Route::delete('product-ajaxis/destroy', 'ProductAjaxController@massDestroy')->name('product-ajaxis.massDestroy');
    Route::post('product-ajaxis/media', 'ProductAjaxController@storeMedia')->name('product-ajaxis.storeMedia');
    Route::post('product-ajaxis/ckmedia', 'ProductAjaxController@storeCKEditorImages')->name('product-ajaxis.storeCKEditorImages');
    Route::resource('product-ajaxis', 'ProductAjaxController');

    // Supplier
    Route::delete('suppliers/destroy', 'SupplierController@massDestroy')->name('suppliers.massDestroy');
    Route::post('suppliers/media', 'SupplierController@storeMedia')->name('suppliers.storeMedia');
    Route::post('suppliers/ckmedia', 'SupplierController@storeCKEditorImages')->name('suppliers.storeCKEditorImages');
    Route::resource('suppliers', 'SupplierController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::post('expenses/media', 'ExpenseController@storeMedia')->name('expenses.storeMedia');
    Route::post('expenses/ckmedia', 'ExpenseController@storeCKEditorImages')->name('expenses.storeCKEditorImages');
    Route::resource('expenses', 'ExpenseController');

    // Purchase
    Route::delete('purchases/destroy', 'PurchaseController@massDestroy')->name('purchases.massDestroy');
    Route::post('purchases/media', 'PurchaseController@storeMedia')->name('purchases.storeMedia');
    Route::post('purchases/ckmedia', 'PurchaseController@storeCKEditorImages')->name('purchases.storeCKEditorImages');
    Route::resource('purchases', 'PurchaseController');

    // Return Purchase
    Route::delete('return-purchases/destroy', 'ReturnPurchaseController@massDestroy')->name('return-purchases.massDestroy');
    Route::post('return-purchases/media', 'ReturnPurchaseController@storeMedia')->name('return-purchases.storeMedia');
    Route::post('return-purchases/ckmedia', 'ReturnPurchaseController@storeCKEditorImages')->name('return-purchases.storeCKEditorImages');
    Route::resource('return-purchases', 'ReturnPurchaseController');

    // Damage Purchase
    Route::delete('damage-purchases/destroy', 'DamagePurchaseController@massDestroy')->name('damage-purchases.massDestroy');
    Route::post('damage-purchases/media', 'DamagePurchaseController@storeMedia')->name('damage-purchases.storeMedia');
    Route::post('damage-purchases/ckmedia', 'DamagePurchaseController@storeCKEditorImages')->name('damage-purchases.storeCKEditorImages');
    Route::resource('damage-purchases', 'DamagePurchaseController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/toggle-two-factor', 'ProfileController@toggleTwoFactor')->name('profile.toggle-two-factor');
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
