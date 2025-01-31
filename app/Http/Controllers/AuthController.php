<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses login
    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'kode_dealer' => 'required|string',  // Menambahkan validasi untuk kode_dealer
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('kode_dealer', 'password');  // Menggunakan kode_dealer dan password

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $kodeDealer = $user->kode_dealer;

            // Menentukan apakah pengguna adalah USERMASTER atau user biasa
            if ($user->role === 'master') {
                // Jika USERMASTER, arahkan ke tampilan yang sesuai (akses ke semua data)
                return redirect()->route('laporan.user.surat', ['kode_dealer' => $kodeDealer])
                    ->with('success', 'Login successful as Master!');
            }

            // Jika user biasa, arahkan ke tampilan yang sesuai (akses ke data mereka saja)
            return redirect()->route('laporan.user.surat', ['kode_dealer' => $kodeDealer])
                ->with('success', 'Login successful as User!');
        }

        return back()->withErrors(['kode_dealer' => 'Invalid credentials.'])->withInput();  // Ganti password error dengan kode_dealer
    }


    // Proses registrasi
    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'kode_dealer' => 'required|string|max:255|unique:users,kode_dealer',  // Menambahkan validasi untuk kode_dealer
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,master', // Pastikan ada role yang dipilih
        ]);

        $user = new User();
        $user->password = Hash::make($request->password);  // Menyimpan password yang telah di-hash
        $user->kode_dealer = $request->kode_dealer;  // Menyimpan kode_dealer
        $user->role = $request->role;  // Menyimpan role (user/master)
        $user->save();

        // Setelah registrasi, login otomatis
        Auth::login($user);

        return redirect('login')->with('success', 'Registration successful!');
    }


    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('success', 'You have been logged out.');
    }
}
