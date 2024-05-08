<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    // public function login(Request $request)
    // {
    // $request->validate([
    //     'username' => 'required',
    //     'password' => 'required',
    // ]);

    // $credentials = $request->only('username', 'password');

    // if (Auth::attempt($credentials)) {
    //     // Ambil peran pengguna setelah berhasil login
    //     $user = Auth::user();
    //     $role = $user->role;

    //     // Cek peran pengguna dan arahkan ke dashboard yang sesuai
    //     switch ($role) {
    //         case 'admin':
    //             return redirect()->route('berandaadmin.show')->with('success', 'Berhasil login');
    //             break;
    //         case 'host':
    //             return redirect()->route('host.dashboard')->with('success', 'Berhasil login');
    //             break;
    //         case 'pengunjung':
    //             return redirect()->route('beranda.show')->with('success', 'Berhasil login');
    //             break;
    //         default:
    //             return redirect()->route('login.showLoginForm')->with('Failed', 'Role tidak valid');
    //             break;
    //     }
    // } else {
    //     return redirect()->route('login.showLoginForm')->with('Failed', 'Username atau password tidak valid');
    // }
    // }


    public function login(Request $request)
    {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('username', 'password');

    // Coba autentikasi sebagai admin
    if (Auth::guard('admin')->attempt($credentials)) {
        session()->flash('login_berhasil', true);
        return redirect()->route('berandaadmin.show')->with('success', 'Berhasil login');
    }

    // Coba autentikasi sebagai pengunjung
    if (Auth::guard('web')->attempt($credentials)) {
        session()->flash('login_berhasil', true);
        return redirect()->route('beranda.show')->with('success', 'Berhasil login');
    }

    if (Auth::guard('host')->attempt($credentials)) {
        session()->flash('login_berhasil', true);
        return redirect()->route('berandahost.show')->with('success', 'Berhasil login');
    }

    // Jika tidak ada autentikasi yang berhasil
    session()->flash('login_gagal', true);
    return redirect()->route('login.showLoginForm')->with('Failed', 'Username atau password tidak valid');
    }


// public function login(Request $request)
// {
//    $request->validate([
//     'username' => 'required',
//     'password' => 'required',
//    ]);

//    $data = [
//     'username' => $request->username,
//     'password' => $request->password,
//    ];

//    if(Auth::attempt($data)){
//     session()->flash('login_berhasil', true);
//     return redirect()->route('beranda.show')->with('succes', 'Berhasil login');
    
//    }else{
//     session()->flash('login_gagal', true);
//     return redirect()->route('login.showLoginForm')->with('Failed', 'username atau password tidak falid');
//    }
// }

    public function logout(){
        Auth::logout();
        return redirect()->route('login.showLoginForm')->with('success', 'Kamu berhasil logout');
    }
}
