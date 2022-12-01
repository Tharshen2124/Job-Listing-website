<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

HTTP METHODS

 GET -  Request a resource
 POST - Create a new resource
 PUT - Update a resource (can modify every single value inside that single row)
 PATCH - Modify a resource ( can modify values that have been changed)
 DELETE -  delete a resource
 OPTIONS - ask the server which verbs are allowed

*/

// 
/**
 * ! get         -> the type of HTTP method 
 * ? '/'         -> URI / endpoint is basically adding a directory to the URl
 * * function () -> a closure which is a function most of the time
 * similar to Express.js
 * ^ inside the the response part for the first parameter, you can send a html code like 
 * ^ <h1>hello</h1> as well instead of a regular string
 * ^ which will render into the browser.
 * 
 
 */

 /**
 * ! Common Resource Routes methods:
 * * index   - Show all Listings
 * * show    - Show single listing
 * * create  - Show form to create new listing
 * * store   - Store new listing
 * * edit    - Show form to edit listing
 * * update  - Update listing
 * * destroy - Delete listing
 */

// All Listing
Route::get('/', [ListingController::class, 'index']);


// SHow Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show Edit Form
Route::get('/listings/{listing}/edit', 
[ListingController::class, 'edit'])->middleware('auth');

// Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// manage Listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');


//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Show register / Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');


// Log in User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);



/**
 * ^ for header('Content-type') you can use choose if its plain or if u want to make it as html text
 * ^ for instance, you can put 'text/html' to render your code u put in response as html
 */
/*
Route::get('/hello', function() {
    return response('print("hello world)', 200)
        ->header('Content-Type', 'text/plain')
        ->header('foo', 'bar');
});
#http://localhost/testingapp/public/hello
*/

/**
 * ! {id} -> this is known as a wildcard endpoint, you're sort of putting a variable into the URI
 * ^ whatever u type as id in the URL of the browser, it will act as a variable and use that value in the code u put in response()
 * 
 * ^ take a look at the number thingy in where(), that is a constraint which is basically a condition
 * ^ if we put like a number in the endpoint of the URL, it will send a 404 error message
 * ^ but if its a number, it will show up
 * 
 * ! dd() -> stands for die and dump which shows the ID 
 * ? ddd() -> stands for dump , die and debug, which shows a bunch of stuff like the breakpoint, cookies laravel version
 */

/*
Route::get('/post/{id}', function($id) {
   
    return response('Post ' . $id);
})->where('id', '[0-9]+');


Route::get('/search', function(Request $request) {
    return $request->name . ' ' . $request->city;
});
*/
Route::get('/something', function(){
    return view("users.login");
});
