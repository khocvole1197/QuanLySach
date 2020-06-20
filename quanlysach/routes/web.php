<?php

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

use App\Book;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => true]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('author', 'AuthorController');
    Route::resource('book', 'BookController');
    Route::resource('trash', 'TrashController');
    Route::resource('customer', 'CustomerController');
//user tra sach
    Route::get('/trasach', 'UserController@traSach')->name('trasach');
    Route::get('/khachtra', 'UserController@khachTra');
//update info
    Route::get('profile', 'UserController@profile')->name('profile');
    Route::post('editInfo', 'UserController@UpdateInfo')->name('UpdateInfo');
//quan ly user
    Route::get('quanlytaikhoan', 'UserController@quanLyUser')->name('quanlytaikhoan');
    Route::get('deleteUser', 'UserController@deleteUser');
    Route::post('/updateUser', 'UserController@updateUser');
    //onlytacgia
    Route::post('/onlyTacGia', 'HomeController@onlyTacGia')->name('onlyTacGia');
});
//Route::get('b', function () {
// UserBackController
// UserBackController
//    $data = Book::all()->where('user_r', Auth::user()->name)->first();
//    $data->update([
//        'name_book' => 'quang',
//        'active' => 1,
//        'user_r' => '1'
//    ]);
//});
//route::get('/test', 'UserController@CheckTime');

