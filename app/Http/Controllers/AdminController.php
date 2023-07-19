<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Version;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    function profile() {
        
        $profile = User::where('id',Auth::id())->first();

        return view('Admin.profile.profile',compact('profile'));
    }
    function settings() {
        
        return view('Admin.profile.change-password');
    }

    function change_password(Request $request) {
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return redirect()->route('change_password')->with('success', 'Password changed successfully.');
        } else {
            throw ValidationException::withMessages(['current_password' => 'The current password is incorrect.']);
        }
    }

    function feedback(Request $request) {
        
        $feedback = Feedback::all();
        
        return view('Admin.feedback.index',compact('feedback'));
    }

    function feedbackStore(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);


    }
    function version(Request $request) {
        
        $versions = Version::all();
        return view ('Admin.version',compact('versions'));
    }

    function addVersion(Request $request) {
        $data = $request->validate([
            'version_name' => 'required',
            'version_code' => 'required|numeric',
        ]);
        
        $inserted = Version::create($data);
        if($inserted) {
            return redirect()->back()->with('success', 'New version added successFully.');
        } else {
            return redirect()->back()->with('error', 'version not added.');
        }
    }

    public function updateVersionStatus(Request $request, $id)
    {
        Version::query()->update(['is_active'=>1]);
        
        $version = Version::findOrFail($id);
        // dd($version);
        if($request->is_active == 0) {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        $version->is_active = $is_active;
        $version->save();

        return response()->json(['success' => true]);
    }
}
