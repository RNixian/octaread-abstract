<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Models\adminmodel; 
use App\Models\booksmodel; 
use App\Models\carouselmodel; 
use App\Models\contactmodel; 
use App\Models\coursemodel; 
use App\Models\departmentmodel; 
use App\Models\membersModel; 
use App\Models\usermodel; 
use App\Models\positionmodel; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Guard;



class AccountController extends Controller
{
    public function useracc()
{
    return view('admin.account.useraccount');
}

public function showdepartment()
{
    $usermodel = usermodel::all();
    return view('admin.account.useraccount')->with('usermodel', $usermodel);

}


public function searchAccount(Request $request)
    {
        $dept = departmentmodel::all();
    
        $query = usermodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->search . '%')
                  ->orWhere('middlename', 'like', '%' . $request->search . '%')
                  ->orWhere('lastname', 'like', '%' . $request->search . '%')
                  ->orWhere('schoolid', 'like', '%' . $request->search . '%')
                  ->orWhere('course', 'like', '%' . $request->search . '%')
                  ->orWhere('birthdate', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('department') && $request->department) {
            $query->where('department', $request->department);
        }
    
        $usermodel = $query->get();
    
        return view('admin.member', compact('usermodel', 'dept'));
    }
    
    public function mmbrs()
    {
        return $this->belongsTo(positionmodel::class, 'position_id', 'position');
    }


    public function deleteuseracc($id)
    {
        $useracc = usermodel::findOrFail($id);
        $useracc->delete(); 
    
        return redirect()->back()->with('success', 'User Account has been deleted successfully!');
    }


    public function updateuseracc(Request $request, $id) {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'schoolid' => 'required|string|max:50',
            'course' => 'required|string|max:100',
            'birthdate' => 'required|date',

        ]);
    
         $post = usermodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.account.useraacount');
    }
    



}

