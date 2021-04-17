<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUniversityRegisterRequest;
use App\Mail\NewAdminUnivRequest;
use App\Models\AdminUniversityRegisterRequest as ModelsAdminUniversityRegisterRequest;
use App\Models\User;
use App\Notifications\NewAdminRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class AdminUniversityRegisterRequestController extends Controller
{
    public function create(AdminUniversityRegisterRequest $request, ModelsAdminUniversityRegisterRequest $model){
        $dataRegister = $request->all();
        
        $hashPassword = Hash::make(request()->password);

        $dataRegister['password'] = $hashPassword;
        
        $model->create($dataRegister);

        $adminRegistrationId = $model->latest()->first()->id;
    
        Mail::to(User::role('super-admin')->first()->email)->send(new NewAdminUnivRequest());

        $superAdmin = User::role('super-admin')->get();

        Notification::sendNow($superAdmin, new NewAdminRegisterRequest($request, $adminRegistrationId));

        alert()->info('Your Registration Has Been Submitted, We Will Send Email If You Are Qualified')
        ->persistent('OK')->autoclose(10000);

        return redirect()->to(route('welcome'));
    }
}
