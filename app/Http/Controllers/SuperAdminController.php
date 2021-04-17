<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCriteria;
use App\Models\Criteria;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //Users Page
    //show all users
    public function showAllUsers(User $user)
    {
        $universityAdminUsers = $user->role('university-admin')->simplePaginate(4);

        $userStudents = $user->role('user-student')->simplePaginate(4);

        return view('admin_page.all_users', 
        compact([
            'universityAdminUsers',
            'userStudents'
        ]));
    }

    //delete user
    public function deleteUser()
    {
        $userId = request()->userId;

        $selectUser = User::find($userId);

        $selectUser->delete();

        alert()->info('Users Has Been Deleted')->persistent('OK')->autoclose(5000);

        return redirect()->to('home');
    }

    //show all criteria
    public function showCriteria()
    {
        $criterias = Criteria::simplePaginate(5);

        return view('admin_page.criteria', compact('criterias'));
    }

    //add new criteria
    public function addNewCriteria(NewCriteria $request)
    {
        $data = $request->all();

        Criteria::create($data);

        alert()->success('You Have Added New Criteria')->persistent('OK')->autoclose(5000);

        return redirect()->to(route('super-admin.show-criteria'));
    }

    //update criteria
    public function updateCriteria(NewCriteria $request, Criteria $criteria)
    {
        $data = $request->all();

        $criteria->where('id', '=', $data['updateId'])->update([
            'name' => $data['name'],
            'highest_value' => $data['highest_value'],
            'average_value' => $data['average_value'],
            'lowest_value' => $data['lowest_value']
        ]);

        alert()->success('You Have Updated The Criteria')->persistent('OK')->autoclose(5000);

        return redirect()->to(route('super-admin.show-criteria'));
    }

    //delete criteria
    public function deleteCriteria()
    {
        $criteriaId = request()->criteriaId;

        $selectedCriteria = Criteria::find($criteriaId);

        $selectedCriteria->delete();

        alert()->success('You Have Deleted The Criteria')->persistent('OK')->autoclose(5000);

        return redirect()->to(route('super-admin.show-criteria'));
    }
}
