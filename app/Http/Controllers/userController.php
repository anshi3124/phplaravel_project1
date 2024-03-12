<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserSignUpReq;
use App\Http\Requests\UserLoginReq;
use Illuminate\Support\Facades\Log;

class userController extends Controller
{
    public function welcome()
    {
     return view('welcome');
    }
    public function index()
    {
     return view('user.user_signup');
    }
    public function login(UserLoginReq $request)
    {
     
     $request->validated();
    // dd($request->all());
     $credential = $request->only('email','password');
     
     if(Auth::attempt($credential) && auth()->user()->role == "user")
      { 
        return redirect('/user/CustDesh');
      }
      else
      {
         return redirect()->back()->withError('User ID and Password Are Invaild');
      }
 
    }
 
    public function signupAction(UserSignUpReq $request)
 {
     try{
         // Validate user input (already handled by UserSignUpReq)
         if($request){
         $request->validated();
           //dd($request->all());
        User::create([
             'name' => $request->name,
             'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
         ]);
        
        //  Redirect with success message
         return redirect('/')->with('status', 'User Created Successfully');
     }else{
         return redirect()->back()->withInput();
     }
    }catch (\Exception $e) {
     
         // Handle any errors during user creation
         // Log the error message for debugging
         Log::error($e->getMessage());

 
         // Display a generic error message to the user
         return redirect('/user/reg')->withError('An error occurred during registration. Please try again.');
    }
 }

    public function viewDesh(){
      return view('user.dashboard');
    }
   
    public function logout(){
       Session::flush();
       Auth::logout();
       return redirect('/');
    }
}
