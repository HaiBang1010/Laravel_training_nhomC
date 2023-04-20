<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }


    public function create($data)
    {
        return User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => FacadesHash::make($data["password"]),
            "image" => $data["fileToUpload"],
            "phone" => $data["phone"],
        ]);
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $file = $request->file('fileToUpload');
        $fileName = $file->getClientOriginalName();

        //Move Uploaded File
        $destinationPath = 'uploads';
        $file->move($destinationPath, $fileName);

        $data = $request->all();
        $data['fileToUpload'] = $fileName;
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return  Redirect("login");
    }
    public function detail($id)
    {
        $user = User::find($id);


        return view('detail', ['user' => $user]);
    }

    public function listUser()
    {
        $users = DB::table('users')->paginate(2);
        return view('listuser', ['users' => $users]);
    }
}
