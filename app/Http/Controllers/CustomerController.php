<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;

class CustomerController extends Controller
{
    // Manual Login Submit (username-based)
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Find user by username first
        $user = User::where('username', $request->username)
                    ->where('role', '2')
                    ->where('status', 1)
                    ->first();

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('beranda')->with('success', 'Berhasil login.');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau akun Anda belum aktif.',
        ])->onlyInput('username');
    }

    // Manual Register Submit (username-based)
    public function registerSubmit(Request $request)
    {
        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users', 'alpha_num'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.alpha_num'  => 'Username hanya boleh mengandung huruf dan angka (tanpa spasi).',
            'username.unique'     => 'Username sudah digunakan, pilih username lain.',
        ]);

        // Create the user
        $user = User::create([
            'nama'     => $validated['nama'],
            'email'    => $validated['email'],
            'username' => strtolower($validated['username']),
            'password' => Hash::make($validated['password']),
            'role'     => '2', // Customer
            'status'   => 1,   // Aktif
        ]);

        // Create the customer profile
        Customer::create([
            'user_id' => $user->id,
        ]);

        // Arahkan ke halaman login
        return redirect()->route('auth.login')->with('success', 'Akun berhasil didaftarkan! Silakan login dengan username Anda.');
    }

    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();

            // Cek apakah email sudah terdaftar
            $registeredUser = User::where('email', $socialUser->email)->first();

            if (!$registeredUser) {
                // Buat user baru
                $user = User::create([
                    'nama'     => $socialUser->name,
                    'email'    => $socialUser->email,
                    'role'     => '2', // Role customer
                    'status'   => 1,   // Status aktif
                    'password' => Hash::make('default_password'), // Password default
                ]);

                // Buat data customer
                Customer::create([
                    'user_id'      => $user->id,
                    'google_id'    => $socialUser->id,
                    'google_token' => $socialUser->token,
                ]);

                Auth::login($user);
            } else {
                Auth::login($registeredUser);
            }

            return redirect()->intended('beranda');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    // Tampilkan daftar customer
    public function index()
    {
        $customer = Customer::orderBy('id', 'desc')->get();
        return view('backend.v_customer.index', [
            'judul' => 'Customer',
            'sub'   => 'Halaman Customer',
            'index' => $customer
        ]);
    }

    // Tampilkan halaman akun customer (dengan pengecekan otorisasi)
    public function akun($id)
    {
        $loggedInCustomerId = Auth::user()->id;

        if ($id != $loggedInCustomerId) {
            return redirect()
                ->route('customer.akun', ['id' => $loggedInCustomerId])
                ->with('msgError', 'Anda tidak berhak mengakses akun ini.');
        }

        $customer = Customer::where('user_id', $id)->first();
        if (!$customer) {
            $customer = Customer::create([
                'user_id' => $id,
            ]);
        }

        return view('v_customer.edit', [
            'judul'     => 'Customer',
            'subJudul'  => 'Akun Customer',
            'edit'      => $customer
        ]);
    }

    // Update data akun customer
    public function updateAkun(Request $request, $id)
    {
        $customer = Customer::where('user_id', $id)->first();
        if (!$customer) {
            $customer = Customer::create([
                'user_id' => $id,
            ]);
        }

        $rules = [
            'nama' => 'required|max:255',
            'hp'   => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];

        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max'   => 'Ukuran file gambar Maksimal adalah 1024 KB.',
        ];

        if ($request->email != $customer->user->email) {
            $rules['email'] = 'required|max:255|email|unique:users,email';
        }

        if ($request->alamat != $customer->alamat) {
            $rules['alamat'] = 'required';
        }

        if ($request->pos != $customer->pos) {
            $rules['pos'] = 'required';
        }

        $validatedData = $request->validate($rules, $messages);

        // Upload dan resize gambar jika ada
        if ($request->file('foto')) {
            if ($customer->user->foto) {
                $oldImagePath = public_path('storage/img-customer/') . $customer->user->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-customer/';

            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);

            $validatedData['foto'] = $originalFileName;
        }

        // Update tabel user dan customer
        $customer->user->update($validatedData);

        $customer->update([
            'alamat' => $request->input('alamat'),
            'pos'    => $request->input('pos'),
        ]);

        return redirect()->route('customer.akun', $id)->with('success', 'Data berhasil diperbarui');
    }

    // Hapus data customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        
        // Hapus foto jika ada
        if ($customer->user && $customer->user->foto) {
            $oldImagePath = public_path('storage/img-customer/') . $customer->user->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        // Hapus user yang terkait
        if ($customer->user) {
            $customer->user->delete();
        }
        
        // Hapus customer (biasanya otomatis terhapus jika ada cascade on delete, tapi untuk pastinya)
        $customer->delete();
        
        return redirect()->route('backend.customer.index')->with('success', 'Data customer berhasil dihapus');
    }
}
