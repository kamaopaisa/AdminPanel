<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;

class NotificationSendController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    function index() {
        
        $users = User::pluck('name','id')->all();

        return view('Admin.notifications.index',compact('users'));
    }
    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_token =  $request->token;

        Auth::user()->save();

        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = User::whereIn('id',$request->users)->whereNotNull('device_token')->pluck('device_token')->all();
            
        $serverKey = 'AAAA2WryBMw:APA91bGwZ91hY2sDqRtO9COfuSqyhKCaULM0HxLPy7DfcKLChhm2MPJrlcdEp06BIpC4VwSSwi-nWNcrwTdCj96WODhWjcMV6Adqo7HJzFqNDEIBYWHpFU-OZIDzWBOiVw5ho3629zHa'; // ADD SERVER KEY HERE PROVIDED BY FCM
    
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        // dd($result);
        

        // $curl2 = curl_init();

        // curl_setopt_array($curl2, array(
        //     CURLOPT_URL => 'https://graph.facebook.com/v17.0/110475311899894/messages',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS =>'{
        //         "messaging_product": "whatsapp",
        //         "to": "+917281955487",
        //         "type": "template",
        //         "template": {
        //             "name": "hello_world",
        //             "language": {
        //                 "code": "en_US"
        //             }
        //         }
        //     }',
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json',
        //         'Authorization: Bearer EAAJS2RCT7WIBADsdZAtMnhzvPoh1Gd9lbh5J7KaJU4Vk4BwgmAL5wjnX4CZCCnXorcqkrxxC1bGlMZAD36Jrnqk7Mcga55spO2JQ7Yfoe1noQhcsXXtPY4IRnxpbm2eVJ0n4EHOaFb5JZCHniZCZBqLp4l43ruEZBai8HBdfe5QwH2fqtob6efp7MzeXa9sTzJDYZCn4F9LRpgZDZD'
        //     ),
        // ));

        // $result2 = curl_exec($curl2);
        // if ($result2 === FALSE) {
        //     die('Curl failed: ' . curl_error($curl2));
        // }  
        // curl_close($curl2);


        return redirect()->back()->with('success', 'Notification sent SuccessFully.');
    }
}