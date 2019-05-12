<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getDanhSach(){
        $user = User::all();
        return view('admin.user.danhsach',['user'=>$user]);
    	
    }
    public function getThem(){
        return view('admin.user.them');
    	
    }
    public function postThem(Request $req){
        $this->validate($req,[
            'name'=>'required|min:6',
            'email'=>'required|email|email:uniquire user,email',
            'password'=>'required|min:6|max:33',
            'passwordAgain'=>'required|same:password'
            ],[
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'name.min'=>'Tên người dùng phải dài hơn 6 kí tự',
            'email.required'=>'Bạn chưa nhập email người dùng',
            'email.email'=>'Bạn chưa nhập đúng định dạng email',
            'email.uniquire'=>'Email đã tồn tại',
            'password.required'=>'Bạn chưa nhập password người dùng',
            'password.min'=>'Password phải dài hơn 6 kí tự',
            'password.max'=>'Password phải ngắn hơn 33 kí tự',
            'passwordAgain.required'=>'Bạn chưa nhập lại password người dùng',
            'passwordAgain.same'=>'Password nhập lại chưa đúng',
        ]);
        $user = new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->password=bcrypt($req->password);
        $user->quyen=$req->quyen;
        $user->save();
        return redirect('admin/user/them')->with('thongbao',"Bạn đã thêm user thành công");
    
    }
    public function getSua($id){
    	$user = User::find($id);
    	return view('admin.user.sua',['user'=>$user]);

    }
    public function postSua(Request $req,$id){
    	$this->validate($req,[
            'name'=>'required|min:6'
            ],[
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'name.min'=>'Tên người dùng phải dài hơn 6 kí tự'
        ]);
        $user = User::find($id);
        $user->name=$req->name;
        if($req->changePassword =="on"){
            $this->validate($req,[
                'password'=>'required|min:6|max:33',
                'passwordAgain'=>'required|same:password'
                ],[
                'password.required'=>'Bạn chưa nhập password người dùng',
                'password.min'=>'Password phải dài hơn 6 kí tự',
                'password.max'=>'Password phải ngắn hơn 33 kí tự',
                'passwordAgain.required'=>'Bạn chưa nhập lại password người dùng',
                'passwordAgain.same'=>'Password nhập lại chưa đúng',
            ]);
            $user->password=bcrypt($req->password);
        }
        $user->save();
        return redirect('admin/user/sua/'.$id)->with('thongbao',"Bạn đã sửa user thành công");     	
    }
    
    public function getXoa($id){
    	$user=User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao',"Bạn đã xóa user thành công");
    }	

}
