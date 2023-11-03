<?php

namespace App\Http\Controllers\Auth;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Membersihkan karakter non-angka dari string 'phone'
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);
    
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required','string', 'min:10', 'max:12'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // Mengecek apakah username sudah ada dalam database
        $existingUser = User::where('username', $data['username'])->first();
        if ($existingUser) {
            // Jika username sudah ada, kembalikan ke halaman login dengan pesan kesalahan
            return redirect()->route('login')->withErrors(['username' => 'Username sudah dipakai']);
        }

        // Jika username belum ada, buat pengguna baru
        $data = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'lpk' => 'LPK2109141338952',
            'picture' => 'avatar.png',
        ])->assignRole('user');
        
        DB::table('collagers')->insert([
            'user_id' => $data->id
        ]);

        return $data;
    }

    /**
 * The user has been registered.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  mixed  $user
 * @return mixed
 */
protected function registered(Request $request, $user)
{
    // Flash a success message to the session
    return redirect()->route('data.uji.coba')->with('pesan', 'Selamat Datang, Registrasi Anda Berhasil Disimpan');

}
}