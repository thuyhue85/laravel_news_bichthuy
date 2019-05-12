<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTincontroller extends Controller
{
    public function getDanhSach(){
    	$data = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['dsLoaiTin'=>$data]);
    	// return view('admin.loaitin.danhsach');
    }
    public function getThem(){
        $dsTheLoai=TheLoai::all();
    	return view('admin.loaitin.them',['dsTheLoai'=>$dsTheLoai]);
    }
    public function postThem(Request $req){
    	$this->validate($req,
    		[
    			'Ten'=>'required|min:3|max:30|unique:LoaiTin,Ten','TheLoai=>required'
			],
			[
				'Ten.required'=>'Loại tin không được để trống',
				'Ten.min'=> 'Độ dài phải lớn hơn 3 kí tự',
				'Ten.max'=> 'Độ dài phải ngắn hơn 30 kí tự',
				'Ten.unique'=>"Loại tin này đã tồn tại",
                'TheLoai.required'=>"Thể loại không được để trống"
    		]);

    	$loaitin = new LoaiTin();
    	$loaitin->Ten = $req->Ten;
    	$loaitin->TenKhongDau = changeTitle($req->Ten,'_',$case=MB_CASE_TITLE);
        $loaitin->idTheLoai = $req->TheLoai;
    	//$loaitin->created_at = new DateTime();
    	$loaitin->save();
    	return redirect('admin/loaitin/them')->with('thongbao','Đã thêm loại tin thành công');

    }
    public function getSua($id){
    	$loaitin = LoaiTin::find($id);
        $dsTheLoai=TheLoai::all();
    	return view('admin.loaitin.sua',['loaitin'=>$loaitin,'dsTheLoai'=>$dsTheLoai]);

    }
    public function postSua(Request $req,$id){
    	$loaitin = LoaiTin::find($id);
    	$this->validate($req,
    		[
    			'Ten'=>'required|min:3|max:30'
			],
			[
				'required'=>'Tên loại tin không được để trống',
				'min'=> 'Độ dài phải lớn hơn 3 kí tự',
				'max'=> 'Độ dài phải ngắn hơn 30 kí tự'
    		]);
    	$loaitin->Ten=$req->Ten;
    	$loaitin->TenKhongDau=changeTitle($req->Ten,'_',$case=MB_CASE_TITLE);
        $loaitin->idTheLoai=$req->TheLoai;
    	$loaitin->save();
    	return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Đã sửa loại tin thành công');	
    }
    // public function postXoa(Request $req,$id){
    // 	$loaitin = LoaiTin::find($id);
    // 	return redirect('admin/loaitin/xoa/'.$id)->with('thongbao','Đã xóa thể loại thành công');	
    // }
    public function getXoa($id){
    	$loaitin = LoaiTin::find($id);
    	$ten = $loaitin->Ten;
    	$loaitin->delete();
    	return redirect('admin/loaitin/danhsach')->with('thongbao',"Đã xóa loại tin $ten thành công");
    }	

}
