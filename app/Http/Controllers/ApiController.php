<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Version;
use Auth;
use Validator;
use stdClass;

class ApiController extends Controller
{

    
    function userlogin(Request $request) {

        $x = new stdClass();
        $validator = Validator::make($request->all(), [            
            'name' => 'required',
            'email' => 'required',
            'device_token' => 'required',
            
        ]);
        
        if ($validator->fails()) { 
           
            return response()->json([
                'status'=>500,
                'message'=>$validator->errors()->first(),
                'data'=>$x
            ]);           
        }

        $userExists = User::where('email',$request->email)->first();
        if($userExists) {

            User::where('id',$userExists->id)
            ->update(['device_token'=>$request->device_token]);
            $data = User::where('id',$userExists->id)->select('id','name','email')->first();

        } else {

            $input['name'] = $request->name;
            $input['email'] = $request->email;
            $input['device_token'] = $request->device_token;
            $input['role_id'] = 2;
            $input['created_at'] = Carbon::now();

            $user = User::create($input);
            $insertedId = $user->id;
            $data = User::where('id',$insertedId)->select('id','name','email')->first();
        }

        if($data)
        {
            return response()->json([
                'status'=>200,
                'message'=>' User logged in',
                'data'=>$data,
            ]); 
        }
        else{
            return response()->json([
                'status'=>201,
                'message'=>'User not logged in',
                'data'=> $x
            ]);     
        }

    }

    function feedbackStore(Request $request) {

        $x = new stdClass();
        $validator = Validator::make($request->all(), [            
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            
        ]);
        
        if ($validator->fails()) { 
           
            return response()->json([
                'status'=>500,
                'message'=>$validator->errors()->first(),
                'data'=>$x
            ]);           
        }

        $input['user_id'] = $request->user_id;
        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['created_at'] = Carbon::now();

        $feedback = Feedback::create($feedback);
        $insertedId = $feedback->id;

        $data = Feedback::where('id',$insertedId)->select('user_id','title','description')->first();

        if($data)
        {
            return response()->json([
                'status'=>200,
                'message'=>'Feedback Submitted',
                'data'=>$data,
            ]); 
        }
        else{
            return response()->json([
                'status'=>201,
                'message'=>'Feedback not submitted',
                'data'=> $x
            ]);     
        }
        
    }

    function checkVersion(Request $request) {
        
        $x = new stdClass();
        $validator = Validator::make($request->all(), [            
            'version' => 'required',
            
        ]);
        
        if ($validator->fails()) { 
           
            return response()->json([
                'status'=>500,
                'message'=>$validator->errors()->first(),
                'data'=>$x
            ]);           
        }

        $version = $request->version;

        $activeVersion = Version::where('is_active', 0)->orderBy('id','DESC')->first();
        if($activeVersion && $activeVersion->version_code == $version) {
            return response()->json([
                'status'=>200,
                'message'=>'Version Matched',
                'data'=>$version,
            ]); 
        }
        else{
            return response()->json([
                'status'=>201,
                'message'=>'Version Not Matched',
                'data'=> $x
            ]);     
        }
        
    }


}
