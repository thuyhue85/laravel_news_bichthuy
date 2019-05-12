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
use App\TestModel;
use App\TheLoai;

Route::get('/', function () {
    return view('welcome');
});

Route::get('QueryBuilder',function(){
	$tmp=DB::table('Test')->where('id',1)->value('Name');
	echo $tmp;
});
Route::get('TestModel',function(){
	echo TestModel::find(1)->Name;

});

Route::get('Test_get_loai_tin_from_the_loai/{n}',function($n){
	$tl = TheLoai::find($n);
	echo 'Tên thể loại:'.$tl->Ten."<br/><br/>";
	$loaitinList = $tl->loaitin;
	// var_dump($loaitinList);
	foreach ($loaitinList as $loaitin) {
		echo $loaitin->Ten."<br/>";
	}
});
Route::group(['prefix'=>'admin'],function(){
	Route::group(['prefix'=>'theloai'],function(){
 		Route::get('danhsach','TheLoaiController@getDanhSach');

 		Route::get('sua/{id}','TheLoaiController@getSua');
 		Route::post('sua/{id}','TheLoaiController@postSua');

 		Route::get('them','TheLoaiController@getThem');
 		Route::post('postthem','TheLoaiController@postThem');

 		Route::get('xoa/{id}','TheLoaiController@getXoa');
 });
	Route::group(['prefix'=>'loaitin'],function(){
 		Route::get('danhsach','LoaiTinController@getDanhSach');

 		Route::get('sua/{id}','LoaiTinController@getSua');
 		Route::post('sua/{id}','LoaiTinController@postSua');

 		Route::get('them','LoaiTinController@getThem');
 		Route::post('postthem','LoaiTinController@postThem');

 		Route::get('xoa/{id}','LoaiTinController@getXoa');
 });
 Route::group(['prefix'=>'user'],function(){
 		Route::get('danhsach','UserController@getDanhSach');

 		Route::get('sua/{id}','UserController@getSua');
 		Route::post('sua/{id}','UserController@postSua');

 		Route::get('them','UserController@getThem');
 		Route::post('postthem','UserController@postThem');

 		Route::get('xoa/{id}','UserController@getXoa');
 });
 Route::group(['prefix'=>'slide'],function(){		
 	Route::get('danhsach','SlideController@getDanhsach');

		Route::get('sua/{id}','SlideController@getSua');
		Route::post('sua/{id}','SlideController@postSua');

		Route::get('them','SlideController@getThem');
		Route::post('them','SlideController@postThem');

		Route::get('xoa/{id}','SlideController@getXoa');
	});
});

