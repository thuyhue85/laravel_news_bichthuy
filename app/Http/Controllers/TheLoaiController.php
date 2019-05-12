<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaicontroller extends Controller
{
    public function getDanhSach(){
    	$data = TheLoai::all();
    	return view('admin.theloai.danhsach',['dsTheLoai'=>$data]);
    	// return view('admin.theloai.danhsach');
    }
    public function getThem(){
    	return view('admin.theloai.them');
    }
    public function postThem(Request $req){
    	$this->validate($req,
    		[
    			'Ten'=>'required|min:3|max:30|unique:TheLoai'
			],
			[
				'required'=>'Thể loại không được để trống',
				'min'=> 'Độ dài phải dài hơn 3 kí tự',
				'max'=> 'Độ dài phải ngắn hơn 30 kí tự',
				'unique'=>"Thể loại này đã tồn tại"
    		]);

    	$theloai = new TheLoai();
    	$theloai->Ten = $req->Ten;
    	$theloai->TenKhongDau = changeTitle($req->Ten);
    	//$theloai->created_at = new DateTime();
    	$theloai->save();
    	return redirect('admin/theloai/them')->with('thongbao','Đã thêm thể loại thành công');

    }
    public function getSua($id){
    	$theloai = TheLoai::find($id);
    	return view('admin.theloai.sua',['theloai'=>$theloai]);

    }
    public function postSua(Request $req,$id){
    	$theloai = TheLoai::find($id);
    	$this->validate($req,
    		[
    			'Ten'=>'required|min:3|max:30|unique:TheLoai'
			],
			[
				'required'=>'Tên thể loại không được để trống',
				'min'=> 'Độ dài phải lớn hơn 3 kí tự',
				'max'=> 'Độ dài phải ngắn hơn 30 kí tự',
				'unique'=>"Thể loại này đã tồn tại"
    		]);
    	$theloai->Ten=$req->Ten;
    	$theloai->TenKhongDau=changeTitle($req->Ten,'_',$case=MB_CASE_TITLE);
    	$theloai->save();
    	return redirect('admin/theloai/sua/'.$id)->with('thongbao','Đã sửa thể loại thành công');	
    }
    // public function postXoa(Request $req,$id){
    // 	$theloai = TheLoai::find($id);
    // 	return redirect('admin/theloai/xoa/'.$id)->with('thongbao','Đã xóa thể loại thành công');	
    // }
    public function getXoa($id){
    	$theloai = TheLoai::find($id);
    	$ten = $theloai->Ten;
    	$theloai->delete();
    	return redirect('admin/theloai/danhsach')->with('thongbao',"Đã xóa thể loại $ten thành công");
    }	

}
