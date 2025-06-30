<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\PostCategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TransactionsController;
use App\Http\Controllers\Api\WeeklyChartController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\TokenVarificationAPIMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// users
Route::post('user-registration',[UserController::class,'userRegistration'])->name('userRegistration');
Route::post('user-login',[UserController::class,'userLogin'])->name('userLogin');
Route::get('user-logout',[UserController::class,'userLogout'])->name('userLogout');
Route::post('send-otp',[UserController::class,'sendOtp'])->name('sendOtp');
Route::post('verify-otp',[UserController::class,'verifyOtp'])->name('verifyOtp');
Route::post('reset-pass',[UserController::class,'resetPassword'])->name('resetPassword')->middleware(TokenVarificationAPIMiddleware::class);

//category
Route::get('/list-category',[CategoryController::class,'listCategory'])->name('listCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/create-category',[CategoryController::class,'createCategory'])->name('createCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/update-category',[CategoryController::class,'updateCategory'])->name('updateCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/delete-category',[CategoryController::class,'deleteCategory'])->name('deleteCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/category-by-id',[CategoryController::class,'categoryById'])->name('categoryById')->middleware(TokenVarificationAPIMiddleware::class);


//post-category-list
Route::get('/post-category-list',[PostCategoryController::class,'postCategoryList'])->name('postCategoryList');
Route::post('/create-post-category',[PostCategoryController::class,'createPostCategory'])->name('createCategory');
Route::get('/post-by-category/{id}',[PostCategoryController::class,'postByCategory'])->name('postByCategory');


//post-list
Route::get('/post-newest',[PostController::class,'postList'])->name('postList');
Route::post('/post-create',[PostController::class,'createPost'])->name('createPost');
Route::get('/post-details/{id}',[PostController::class,'postDetails'])->name('postDetails');

// Expense Statistics react batch 4 bank dash apis

Route::get('/expense-list',[ExpenseController::class,'expenseList'])->name('expenseList');
Route::post('/expense-create',[ExpenseController::class,'createExpense'])->name('createExpense');


//weekly-activity 
Route::get('/weekly-activity-list',[WeeklyChartController::class,'weeklyActivityList'])->name('weeklyActivityList');
Route::post('/weekly-activity-create',[WeeklyChartController::class,'createWeeklyActivity'])->name('createWeeklyActivity');

//card
Route::get('/card-list',[CardController::class,'cardList'])->name('cardList');
Route::post('/card-create',[CardController::class,'createCard'])->name('createCard');


//recent-transactions
Route::get('/recent-transactions-list',[TransactionsController::class,'recentTransactionsList'])->name('recentTransactionsList');
Route::post('/recent-transactions-create',[TransactionsController::class,'createRecentTransaction'])->name('createRecentTransaction');


//customer
Route::post('/create-customer',[CustomerController::class,'createCustomer'])->name('createCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/list-customer',[CustomerController::class,'listCustomer'])->name('createCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/update-customer',[CustomerController::class,'updateCustomer'])->name('updateCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/delete-customer',[CustomerController::class,'deleteCustomer'])->name('deleteCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/customer-by-id',[CustomerController::class,'customerById'])->name('customerById')->middleware(TokenVarificationAPIMiddleware::class);

// products
Route::post('/create-product',[ProductController::class,'createProduct'])->name('createProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/list-product',[ProductController::class,'listProduct'])->name('listProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/delete-product',[ProductController::class,'deleteProduct'])->name('deleteProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/update-product',[ProductController::class,'updateProduct'])->name('updateProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/product-by-id',[ProductController::class,'productById'])->name('productById')->middleware(TokenVarificationAPIMiddleware::class);


//invoice
Route::post('create-invoice',[InvoiceController::class,'createInvoice'])->name('createInvoice')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('delete-invoice',[InvoiceController::class,'deleteInvoice'])->name('deleteInvoice')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('list-invoice',[InvoiceController::class,'listInvoice'])->name('listInvoice')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('invoce-details',[InvoiceController::class,'invoiceDetails'])->name('invoiceDetails')->middleware(TokenVarificationAPIMiddleware::class);


//post-categories for reactjs project

Route::post('post-categories',[UserController::class,'postCategories'])->name('postCategories');