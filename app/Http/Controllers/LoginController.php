<?php

namespace App\Http\Controllers;

use App\Models\DataMitra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            toast('Anda Berhasil Login', 'success');
            if (auth()->user()->role == 'Admin') {
                return redirect()->intended('/transaksi');
            } else if (auth()->user()->role == 'Bank') {
                return redirect()->intended('/bank');
            } else if (auth()->user()->role == 'Mitra') {
                return redirect()->intended('/mitra');
            } else if (auth()->user()->role == 'Accounting') {
                return redirect()->intended('/accounting');
            }
        }

        toast('Email atau password salah', 'success');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register()
    {
        // if (Session::get('roll') == 2) {
        //     return redirect('home');
        // }elseif(Session::get('roll') == 1){
        //     return redirect('/dashboard');
        // }else
        //     return view('regis');
        // }
        return view('login.create');
    }

    public function actionregis(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|max:255|exists:Person,name',
            'email' => 'required|email:dns|exists:Person,email',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8'
        ]);
        $person_id = DataMitra::where('email', $request->email)->select('id')->first();
        $data = new User([
            'person_id' => $person_id->id,
            'email' => $request->get('email'),
            'password' => hash::make($request->get('password'))
        ]);
        $data->save();
        return back()->with('/login', 'Register Succes! You can LogIn Now');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // use AuthenticatesUsers;

    // protected $redirectTo;
    // public function redirectTo()
    // {
    //     switch (Auth::user()->role) {
    //         case 'admin':
    //             $this->redirectTo = '/admin';
    //             return $this->redirectTo;
    //             break;
    //         case 'mitra':
    //             $this->redirectTo = '/mitra';
    //             return $this->redirectTo;
    //             break;
    //         default:
    //             $this->redirectTo = '/login';
    //             return $this->redirectTo;
    //     }

    //     // return $next($request);
    // }
}
