<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }



    /**
     * Update profile information.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function updateProfile(Request $request){
        try{
            

            $validationRules = [
                'name' => 'required|min:6',
                'password' => 'nullable|confirmed',
            ];

            $this->validate($request,$validationRules);  

            $filteredData  = $request->only(['name']);

            if($request->has('password')){
                $filteredData['password'] = bcrypt($request->get('password'));
            }




            $userObj  = \Auth::user();

            $userObj->fill($filteredData)->save();

            return \Redirect::route('home')->with(['success' => trans('messages.success.profile_update')]);
            
        }catch(\Exception $exp){
 
            self::logError($exp, __CLASS__, __METHOD__);
            return \Redirect::back()->withInput()->with(['serverError' => trans('messages.error.server_error')]);
        }    
    }
}
