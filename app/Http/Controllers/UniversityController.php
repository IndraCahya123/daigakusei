<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Major;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UniversityController extends Controller
{
    public function index(){
        $profile = Auth::user()->university;

        $selectedUniv = University::find($profile->id);

        $criterias = Criteria::get()->all();

        $selectAllMajors = $selectedUniv->majors->all();

        return view('university_page.university-profile', compact(['profile', 'selectedUniv', 'criterias', 'selectAllMajors']));
    }

    public function updateUniversityProfile(Request $request, University $university)
    {   
        $request->validate([
            'thumbnail' => 'image|max:2048'
        ]);

        $univId = $request->user_id;

        $data = $request->all();

        if ($request->file('thumbnail') === null) {
            $data['thumbnail'] = $university->where('id', '=', $univId)->first()->thumbnail;
        } else {
            Storage::delete($university->where('id', '=', $univId)->first()->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('images/univ_thumbnail');
            
            $data['thumbnail'] = $thumbnail;
        }
        
        $university->where('id', '=', $request->user_id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'about' => $request->about,
            'thumbnail' => $data['thumbnail']
        ]);

        alert()->success('You Have Updated University Profile')
        ->persistent('OK')->autoclose(5000);

        return redirect()->to(route('university.university-profile'));
    }

    public function addNewMajor(Request $request, Major $major)
    {
        $data = $request->all();

        $criterias = Criteria::get()->all();

        $selectUniv = $major->where('univ_id', '=', $data['univ_id'])->get()->all();

        foreach ($selectUniv as $select) {
            if ($select->name === $data['name']) {
                alert()->warning('Major Exists')->persistent('OK')->autoclose(5000);
                return redirect()->to(route('university.university-profile'));
            }
        }
        foreach ($criterias as $criteria) {
            $array_data[] = [
                'name' => $criteria->name, 
                'value' => $data['select-' . $criteria->id],
            ];
        }
        
        $major->create([
            'univ_id' => $data['univ_id'],
            'name' => $data['name'],
            'about' => $array_data
        ]);

        alert()->success('You Have Added New Major')->persistent()->autoclose(5000);

        return redirect()->to(route('university.university-profile'));
    }

    public function updateMajor(Request $request, Major $major)
    {
        $data = $request->all();

        $criterias = Criteria::get()->all();

        foreach ($criterias as $criteria) {
            $array_data[] = [
                'name' => $criteria->name, 
                'value' => $data['select-' . $criteria->id],
            ];
        }
        
        $updated = $major->whereKey($request->major_id)->update([
            'univ_id' => $data['univ_id'],
            'name' => $data['name'],
            'about' => $array_data
        ]);

        if ($updated == true) {
            alert()->success('Major Data Has Been Updated')->persistent('OK')->autoclose(5000);
            return redirect()->to(route('university.university-profile'));
        } else {
            alert()->warning('Something Wrong')->persistent('OK')->autoclose(5000);
            return redirect()->to(route('university.university-profile'));
        }
    }

    //delete major
    public function deleteMajor(Request $request, Major $major)
    {
        $majorId = $request->majorId;

        $major->whereKey($majorId)->delete();

        alert()->success('You Have Deleted The Major')->persistent('OK')->autoclose(5000);

        return redirect()->to(route('university.university-profile'));
    }
}
