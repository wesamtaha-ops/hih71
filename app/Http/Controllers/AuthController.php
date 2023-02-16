<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use \App\Models\Topic;
use \App\Models\Level;
use \App\Models\Teacher;
use \App\Models\TeacherLevel;
use \App\Models\TeacherCourse;
use \App\Models\TeacherTopic;
use \App\Models\TeacherTrain;
use \App\Models\TeacherStudyType;
use \App\Models\TeacherExperience;
use \App\Models\TeacherCertificate;

use \App\Models\User;
use \App\Models\Language;
use \App\Models\Course;
use \App\Models\LanguageLevel;
use \App\Models\Currency;
use \App\Models\Country;

use Auth;
use \App\Http\Resources\CountryResource;
use \App\Http\Resources\CurrencyResource;
use \App\Http\Services\ParsingService;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function forget() {
        return view('auth.forget');
    }

    public function register($user_type = 'student') {
        $register_form = view('auth.components.register_form', [
            'user_type' => $user_type
        ]);
        $verify_form = view('auth.components.verify_form');

        return view('auth.register', [
            'register_form' => $register_form,
            'verify_form' =>  $verify_form,
            'user_type' => $user_type
        ] );
    }

    public function register_func(Request $request) {
        // validation
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:11|numeric',
            'type' => 'required',
        ]);

        // get request data
        $data = $request->only(['name','email','password','phone', 'type' ]);

        // hash password
        $data['password'] = bcrypt($data['password']);

        $data['slug'] = Str::slug($data['name']);

        if($data['type'] == 'student') {
            $data['is_approved'] = 1;
        }

        // generate otp
        $digits = 8;
        $data['otp'] = rand(pow(10, $digits-1), pow(10, $digits)-1);

        // insert data into db
        User::insert($data);

        $s = Mail::to($data['email'])->send(new OTPMail($data['otp']));

        return ['success' => '1'];
    }

    public function verify_otp() {
        return view('auth.verify');
    }

    public function verify_otp_func(Request $request) {
        // validation
        $request->validate([
            'otp' => 'required|string'
        ]);

        $otp_verified = User::where('otp', $request->otp)->exists();
 
        if($otp_verified) {
            User::where('otp', $request->otp)->update(['is_verified' => 1]);

            $user = User::where('otp', $request->otp)->first();

            \Auth::loginUsingId($user->id);
            
            return ['success' => '1'];
        } else {
            return ['success' => '0'];
        }

    }

    public function login() {
        return view('auth.login', ['error' => '']);
    }

    public function login_func(Request $request) {

        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        if(Auth::attempt($credentials)) {
            return redirect()->route('home');       
        } else {
            return view('auth.login', ['error' => 'Email/Password is wrong']);
        }
    }

    public function logout() {
        Session::flush();
        
        Auth::logout();

        return redirect('/');
    }

    public function upload_image(Request $request) {

        $request->validate([
            'file.*' => 'required|image|mimes:png,jpg,jpeg|max:2048',    
        ]);

        $files = $request->files;

        foreach($files as $file) {
            $imageName = time().'.jpg';

            // Public Folder
            $file->move(public_path('images'), $imageName);
    
            User::whereId(\Auth::id())->update(['image' => $imageName]);
            
            return $imageName;
        }
    }

    
}
