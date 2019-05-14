<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaiKhoan;
use Illuminate\Support\Facades\Auth;

class TaiKhoanController extends Controller
{
    public function getThemTK() {
    	return view('admin.qltk.themtk');
    }
    public function postThemTK(Request $request) {
    	$this->validate($request, 
    		[
    			'hoTen' => 'required',
                'username' => 'required|max:32|unique:taikhoan,username',
    			'password' => 'required|min:8',
    			'passwordagain' => 'required|same:password',
                'chucVu' => 'required',
                'gioiTinh' => 'required',
                'email' => 'required|email',
                'sdt' => 'required'
    		],
    		[
    			'hoTen.required' => 'Bạn chưa nhập họ tên',
                'username.required' => 'Bạn chưa nhập tên tài khoản',
                'username.max' => 'Tên tài khoản dài hơn mức cho phép',
                'username.unique' => 'Tên tài khoản đã tồn tại',
    			'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu ngắn hơn mức cho phép',
    			'passwordagain.required' => 'Bạn chưa nhập lại mật khẩu',
    		    'passwordagain.same' => 'Mật khẩu không trùng',
                'chucVu.required' => 'Bạn chưa nhập chức vụ' ,
                'gioiTinh.required' => 'Bạn chưa nhập giới tính' ,
                'email.required' => 'Bạn chưa nhập email' ,
                'email.email' => 'Bạn nhập sai định dạng email',
                'sdt.required' => 'Bạn chưa nhập số điện thoại',
    		]);
    	$taikhoan = new TaiKhoan;
    	$taikhoan->hoTen = $request->hoTen;
    	$taikhoan->username = $request->username;
    	$taikhoan->password = bcrypt($request->password);
   		$taikhoan->gioiTinh = $request->gioiTinh;
    	$taikhoan->email = $request->email;
    	$taikhoan->chucVu = $request->chucVu;
    	$taikhoan->sdt = $request->sdt;
    
    	$taikhoan->save();

    	return redirect('admin/qltk/themtk')->with('thongbao','Thêm thành công');
    }

    public function getTimKiemTK() {
        return view('admin.qltk.timkiemtk');
    }
    public function postTimKiemTK(Request $request) {
        $tukhoa = $request->tukhoa;
        $tieuchi = $request->tieuchi;
        $taikhoan = TaiKhoan::where($tieuchi,'=',$tukhoa)->get();

        // if($tieuchi == 'hoTen') {
        //     $taikhoan = TaiKhoan::where('hoTen',$tukhoa);
        // }
        return view('admin.qltk.timkiemtk',['taikhoan'=>$taikhoan]);

    }

    public function getXemTK($username) {
        $user = TaiKhoan::find($username);
        return view('admin.qltk.xemtk',['user'=>$user]);
    }

    public function getSuaTK($username) {
        $user = TaiKhoan::find($username);
        return view('admin.qltk.suatk',['user'=>$user]);
    }
    public function postSuaTK(Request $request, $username) {
        $taikhoan = TaiKhoan::find($username); 
        $this->validate($request, 
            [
                'hoTen' => 'required',
                'chucVu' => 'required',
                'gioiTinh' => 'required',
                'email' => 'required|email',
                'sdt' => 'required'
            ], 
            [
                'hoTen.required' => 'Bạn chưa nhập họ tên',
                'chucVu.required' => 'Bạn chưa nhập chức vụ' ,
                'gioiTinh.required' => 'Bạn chưa nhập giới tính' ,
                'email.required' => 'Bạn chưa nhập email' ,
                'email.email' => 'Bạn nhập sai định dạng email',
                'sdt.required' => 'Bạn chưa nhập số điện thoại',
            ]);
        $taikhoan->hoTen = $request->hoTen;
        $taikhoan->gioiTinh = $request->gioiTinh;
        $taikhoan->email = $request->email;
        $taikhoan->chucVu = $request->chucVu;
        $taikhoan->sdt = $request->sdt;

        if($request->password != null) {
            $this->validate($request,
            [
                'password' => 'min:8',
                'passwordagain' => 'required|same:password',
            ],
            [
                'password.min' => 'Mật khẩu ngắn hơn mức cho phép',
                'passwordagain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordagain.same' => 'Mật khẩu không trùng',
            ]);
            $taikhoan->password = bcrypt($request->password);
        }

        $taikhoan->save();  

        return redirect('admin/qltk/suatk/'.$username)->with('thongbao','Sửa thành công');  
    }

    public function getXoaTK($username) {
        $taikhoan = TaiKhoan::find($username);
        $taikhoan->delete();
        return view('admin.home')->with('thongbao','Xoá thành công');
    }

    public function getXemTKCN($username) {
        $user = Auth::user();
        return view('admin.qltkcn.xemtkcn',['user'=>$user]);
    }

    public function getSuaTKCN($username) {
        $user = Auth::user();
        return view('admin.qltkcn.suatkcn',['user'=>$user]);
    }
    public function postSuaTKCN(Request $request, $username) {
        $taikhoan = Auth::user(); 
        $this->validate($request, 
            [
                'hoTen' => 'required',
                'gioiTinh' => 'required',
                'email' => 'required|email',
                'sdt' => 'required'
            ], 
            [
                'hoTen.required' => 'Bạn chưa nhập họ tên',
                'gioiTinh.required' => 'Bạn chưa nhập giới tính' ,
                'email.required' => 'Bạn chưa nhập email' ,
                'email.email' => 'Bạn nhập sai định dạng email',
                'sdt.required' => 'Bạn chưa nhập số điện thoại',
            ]);

        $taikhoan->gioiTinh = $request->gioiTinh;
        $taikhoan->email = $request->email;
        $taikhoan->chucVu = $request->chucVu;
        $taikhoan->sdt = $request->sdt;

        if($request->password != null) {
            $this->validate($request,
            [
                'password' => 'min:8',
                'passwordagain' => 'required|same:password',
            ],
            [
                'password.min' => 'Mật khẩu ngắn hơn mức cho phép',
                'passwordagain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordagain.same' => 'Mật khẩu không trùng',
            ]);
            $taikhoan->password = bcrypt($request->password);
        }

        $taikhoan->save();  

        return redirect('admin/qltk/suatk/'.$username)->with('thongbao','Sửa thành công');  
    }


    public function getDangNhap() {
        return view('login');
    }
    public function postDangNhap(Request $request) {
        $this->validate($request,
            [
                'username'=>'required',
                'password'=>'required'
            ],
            [
                'username.required' => 'Bạn chưa nhập tên tài khoản',
                'password.required' => 'Bạn chưa nhập mật khẩu'
            ]);
        $data = ['username' => $request->username, 'password'=>$request->password];
        
        if(Auth::attempt($data))
        {   
            $user = Auth::user();
            if($user->chucVu == 'Sinh viên') {
                return redirect('sinhvien/home');
            }
            if($user->chucVu == 'Admin') {
                return redirect('admin/home');
            }
            if($user->chucVu == 'Cán bộ') {
                return redirect('canbo/home');
            }
        } else
            {
                return redirect('dangnhap')->with('thongbao',
                    'Đăng nhập không thành công');
            }

    }

    public function getDangXuat() {
        Auth::logout();
        return redirect('dangnhap');
    }

}
