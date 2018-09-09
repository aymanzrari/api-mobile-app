<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

Route::get('/bcrypt/{password}', function ($password) {
    return bcrypt($password);
});


Route::get('/terms', function () {
	 $termsOfUse = DB::table('application_static_pages')->where(['id' => 'rules', 'deleted_at' => null])->select('title', 'value')->get();
    return view('terms',['data'=>$termsOfUse]);
});
