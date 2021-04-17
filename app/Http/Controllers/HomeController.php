<?php

namespace App\Http\Controllers;

use App\Mail\AdminUnivRegistered;
use App\Mail\dismissedAdminUniv;
use App\Models\AdminUniversityRegisterRequest;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::get();

        return view('home', compact('users'));
    }

    public function createAdminUniv(Request $request){
        //check if there's request admin from the same university
        $requestUniv = request()->university;

        $selectedUniv = University::where('name', '=', $requestUniv)->get();

        if ($selectedUniv->count() == 0) {
            //add new user with role admin university
            $dataUser = $request->all();
            $dataUser['name'] = request()->adminName;
            $dataUser['email'] = request()->adminEmail;
            
            User::create($dataUser)->assignRole('university-admin');
            
            //every user with role admin university has one university to customized
            $dataUniv = $request->all();
            $dataUniv['user_id'] = User::latest()->first()->id;
            $dataUniv['name'] = request()->university;
            $dataUniv['phone'] = request()->phone;
            
            University::create($dataUniv);

            //send mail to new admin university email that he/she has been registered
            Mail::to(request()->adminEmail)->send(new AdminUnivRegistered());
            
            //make the notifications of new admin university request mark as read
            $admin = User::find(1);
            $notifId = request()->notifId;
            $getNotif = $admin->notifications->where('id', '=', $notifId)->first();
            $getNotif->markAsRead();

            //delete the request
            $adminUnivRequestId = $getNotif->data['request_id'];
            AdminUniversityRegisterRequest::find($adminUnivRequestId)->delete();

            //sweet alert if all of this work well
            alert()->info('Add New Admin University Success')
            ->persistent('OK')->autoclose(3500);
        } else {
            alert()->error('Admin University is Already Exist')->persistent('OK')->autoclose(10000);
        }        

        return redirect()->to('home');
    }

    public function dismissedAdminUniv(Request $request)
    {
        $notifId = $request->adminUnivDismissedId;
        $selectedNotif = User::find(1)->notifications->where('id', '=', $notifId)->first();

        //mark as read
        $selectedNotif->markAsRead();

        //delete the request
        $adminUnivRequestId = $selectedNotif->data['request_id'];
        AdminUniversityRegisterRequest::find($adminUnivRequestId)->delete();

        $adminUnivEmail = $request->adminEmail;
        Mail::to($adminUnivEmail)->send(new dismissedAdminUniv());

        alert()->warning('Success to Dismiss the Request')->persistent('CLOSE')->autoclose(5000);

        return redirect()->to('/home');
    }
}
