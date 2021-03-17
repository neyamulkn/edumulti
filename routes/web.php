<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Auth::routes();
//reset for
Route::get('password/recover', 'Auth\ForgotPasswordController@passwordRecover')->name('password.recover');
//forgot password notify send
Route::match(array('GET','POST'), 'password/recover/notify', 'Auth\ForgotPasswordController@passwordRecoverNotify')->name('password.recover');
//verify token or otp
Route::get('password/recover/verify', 'Auth\ForgotPasswordController@passwordRecoverVerify')->name('password.recoverVerify');
//passord update
Route::post('password/recover/update', 'Auth\ForgotPasswordController@passwordRecoverUpdate')->name('password.recoverUpdate');



Route::get('/', 'HomeController@index')->name('home');
Route::get('404', 'HomeController@page404')->name('404');
Route::get('about-us', 'HomeController@aboutUs')->name('aboutUs');
Route::get('courses/{category?}/{subcategory?}', 'HomeController@courses')->name('courses');
Route::get('blog', 'HomeController@blog')->name('blog');
Route::get('pricing', 'HomeController@pricing')->name('pricing');
Route::get('contact-us', 'HomeController@contactUs')->name('contactUs');


Route::get('course/{slug?}', 'HomeController@course_details')->name('course_details');


Route::get('social-login/redirect/{provider}', 'SocialLoginController@redirectToProvider')->name('social.login');
Route::get('social-login/{provider}/callback', 'SocialLoginController@handleProviderCallback')->name('social.callback');
