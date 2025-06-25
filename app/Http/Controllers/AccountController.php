<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Models\adminmodel; 
use App\Models\booksmodel; 
use App\Models\carouselmodel; 
use App\Models\contactmodel; 
use App\Models\coursemodel; 
use App\Models\usertypemodel; 
use App\Models\userdeptmodel;
use App\Models\departmentmodel; 
use App\Models\membersModel; 
use App\Models\usermodel; 
use App\Models\positionmodel; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Guard;

class AccountController extends Controller
{
    public function useracc(Request $request)
    {
        $users = usermodel::all();
        $usertypes = usertypemodel::all();
        $userdepts = userdeptmodel::all();
    
        $query = usermodel::query();
    
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->search . '%')
                  ->orWhere('middlename', 'like', '%' . $request->search . '%')
                  ->orWhere('lastname', 'like', '%' . $request->search . '%')
                  ->orWhere('schoolid', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%')
                  ->orWhere('birthdate', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
    
        $usermodel = $query->paginate(15)->withQueryString();
    
        return view('admin.account.useraccount', compact('usermodel', 'users', 'usertypes', 'userdepts'));
    }
    
   
    
    public function deleteuseracc($id)
    {
        $useracc = usermodel::findOrFail($id);
        $useracc->delete();
    
        return redirect()->back()->with('success', 'User account has been deleted successfully!');
    }
    public function edituseracc($id)
{
    // Eager load 'usertype' relationship
    $useracc = usermodel::with('usertype')->find($id);

    if (!$useracc) {
        return redirect()->route('admin.account.useraccount')->with('error', 'Account not found.');
    }

    $dept = departmentmodel::all();
    $usermodel = usermodel::all();
    $usertypes = usertypemodel::all();
    $userdepts = userdeptmodel::all();

    return view('admin.account.useraccount', compact('useracc', 'usermodel', 'dept', 'usertypes', 'userdepts'));
}

    public function updateuseracc(Request $request, $id)
    {
        $request->validate([
            'firstname'     => 'required|string|max:255',
            'middlename'    => 'nullable|string|max:255',
            'lastname'      => 'required|string|max:255',
            'schoolid'      => 'required|string|max:50',
            'department'    => 'required|string|max:100',
            'birthdate'     => 'required|date',
            'user_type_id'  => 'required|exists:usertype,id',
        ]);
    
        $useracc = usermodel::findOrFail($id);
        $useracc->update($request->all());
    
        return redirect()->route('admin.account.useraccount')->with('success', 'User account updated successfully!');
    }
    
    public function getUserDept($user_type)
    {
        $type = usertypemodel::where('user_type', $user_type)->first();
    
        if (!$type) {
            return response()->json([]);
        }
    
        $departments = userdeptmodel::where('user_type_id', $type->id)->pluck('user_department');
    
        return response()->json($departments);
    }

 


//=============================================================================================================================================

public function adminacc()
{
    return view('admin.account.adminaccount');
}


public function searchAdminAccount(Request $request)
    {
        $dept = departmentmodel::all();
        $adminacc = adminmodel::all();
        $query = adminmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->search . '%')
                  ->orWhere('middlename', 'like', '%' . $request->search . '%')
                  ->orWhere('lastname', 'like', '%' . $request->search . '%')
                  ->orWhere('schoolid', 'like', '%' . $request->search . '%')
                  ->orWhere('birthdate', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('department') && $request->department) {
            $query->where('department', $request->department);
        }
    
        $adminmodel = $query->paginate(15)->withQueryString();
    
        return view('admin.account.adminaccount', compact('adminmodel', 'dept', 'adminacc'));
    }
    
  

    public function deleteadminacc($id)
    {
        $adminacc = adminmodel::findOrFail($id);
        $adminacc->delete(); 
    
        return redirect()->back()->with('success', 'admin Account has been deleted successfully!');
    }

    
    public function editadminacc($id)
{
    $adminacc = adminmodel::find($id);

    if (!$adminacc) {
        return redirect()->route('admin.account.adminaccount')->with('error', 'Account not found.');
    }

    return view('admin.account.adminaccount', compact('adminacc'));
}


public function updateadminacc(Request $request, $id) {
    $validatedData = $request->validate([
        'firstname' => 'required|string|max:255',
        'middlename' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'schoolid' => 'required|string|max:50',
        'birthdate' => 'nullable|date',
    ]);

    $post = adminmodel::findOrFail($id); // It's better to use findOrFail for error handling
    $post->fill($validatedData);
    $post->save();

    return redirect()->route('admin.account.adminaccount');
}

    
    //GUEST

    public function guestlog(Request $request)
    {
       
        $query = usermodel::where('user_type_id', 0);
        // Apply search filter if present
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->search . '%')
                  ->orWhere('middlename', 'like', '%' . $request->search . '%')
                  ->orWhere('lastname', 'like', '%' . $request->search . '%')
                  ->orWhere('schoolid', 'like', '%' . $request->search . '%')
                  ->orWhere('birthdate', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        // Apply department filter if present
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
    
        // Execute final query
        $usersmodel = $query->paginate(15)->withQueryString();
    
        return view('admin.account.guestlog', ['users' => $usersmodel]);

    }
    

    
        public function deleteguestlog($id)
        {
            $guestlog = usermodel::findOrFail($id);
            $guestlog->delete(); 
        
            return redirect()->back()->with('success', 'admin Account has been deleted successfully!');
        }





        public function index()
        {
             $carouselItems = carouselmodel::orderBy('display_order')->get();

           return view('index', compact('carouselItems'));
        }
        



}

