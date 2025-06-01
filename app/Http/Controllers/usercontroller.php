<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\booksmodel; 
use App\Models\carouselmodel; 
use App\Models\contactmodel; 
use App\Models\programmodel; 
use App\Models\programplusmodel; 
use App\Models\departmentmodel; 
use App\Models\membersModel; 
use App\Models\usermodel; 
use App\Models\positionmodel; 
use App\Models\favmodel; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class usercontroller extends Controller
{

    // USER REGISTRATION------------------------------------------------------------------------------------------------------------------------

    public function registeruser()
    {
        $departments = DepartmentModel::all();
        $programpluses = ProgramPlusModel::all();
        $programs = ProgramModel::all();
    
        return view('pages.registeruser', compact('departments', 'programpluses', 'programs'));
    }
    public function storeuser(Request $request)
    {
        $data = $request->validate([
            'firstname'  => 'required',
            'middlename' => 'required',
            'lastname'   => 'required',
            'schoolid' => 'required|unique:users,schoolid',
            'course'     => 'required',
            'birthdate'  => 'required|date',
        ]);
    
        // Store data, no need for hashing birthdate
        usermodel::create([
            'firstname'  => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname'   => $data['lastname'],
            'schoolid'   => $data['schoolid'],
            'course'     => $data['course'],
            'birthdate'  => $data['birthdate'], 
        ]);
    
        return redirect()->route('pages.userlogin')->with('success', 'Registration successful.');
    }


    // USER LOGIN------------------------------------------------------------------------------------------------------------------------------------------------
    public function userloginview()
    {
        return view('pages.userlogin');
    }
    
    // Example LoginController
    public function userlogin(Request $request)
    {
        // Validate inputs
        $request->validate([
            'schoolid' => 'required',
            'birthdate' => 'required|date',
        ]);
    
        
        // Query the user based on schoolid and birthdate
        $user = Usermodel::where('schoolid', $request->schoolid)
            ->where('birthdate', $request->birthdate)
            ->first(); // Get the first matching user
    
        // Check if a user was found
        if ($user) {
            // Update status to active
            $user->status = 'active';
            $user->save();
        
            // Store user data in the session
            session([
                'userid' => $user->id,
                'firstname' => $user->firstname,
            ]);
        
            // Redirect to the ebook page
            return redirect()->route('pages.userdashboard');

        }else {
            // Redirect back with an error message if no user was found
            return back()->withErrors(['Invalid School ID or Birthdate']);
        }
    }
    

    
  // USER LOGOUT------------------------------------------------------------------------------------------------------------------------------------------------
  public function logoutuser(Request $request)
  {
      $userId = session('userid');
      if ($userId) {
          $user = usermodel::find($userId);
          if ($user) {
              $user->status = 'inactive';
              $user->save();
          }
      }
  
      session()->flush(); // Clear all session data
      return redirect()->route('pages.userlogin')->with('success', 'You have been logged out.');
  }
  
  
    // USER DASHBOARD -------------------------------------------------------------------------------------------------------------------------------------------------------
 
    public function userdashboard()
    {
        $carouselItems = carouselmodel::orderBy('display_order')->get();
        $members = membersmodel::all();
        $ebooks = booksmodel::orderBy('created_at', 'desc')->take(4)->get(); 
        return view('pages.userdashboard', compact('carouselItems', 'members', 'ebooks'));
    }
    
    
    
// USER DASHBOARD -------------------------------------------------------------------------------------------------------------------------------------------------------
public function userebook(Request $request)
{
    $departments = departmentmodel::all();

    $query = booksmodel::query();

    // Apply search filters
    if ($request->has('search') && $request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('author', 'like', '%' . $request->search . '%')
              ->orWhere('year', 'like', '%' . $request->search . '%')
              ->orWhere('department', 'like', '%' . $request->search . '%')
              ->orWhere('category', 'like', '%' . $request->search . '%')
              ->orWhere('pdf_filepath', 'like', '%' . $request->search . '%')
              ->orWhere('created_at', 'like', '%' . $request->search . '%')
              ->orWhere('updated_at', 'like', '%' . $request->search . '%');
        });
    }

    // Apply department filter
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Apply category filter
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Use paginate instead of get
    $ebooks = $query->paginate(10)->withQueryString(); // ✅ fixed here

    return view('pages.userebook', compact('ebooks', 'departments'));
    
}


//PROFILE----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
public function userprofile(Request $request)
    {
        $userid = $request->session()->get('userid');
        $user = usermodel::find($userid);

        if (!$user) {
            return redirect()->route('pages.userlogin')->with('error', 'User not found. Please log in again.');
        }

        $TotalFavBooks = favmodel::count();[
            'TotalFavBooks' => $TotalFavBooks,
        ];

        return view('pages.userprofile', compact('user', 'TotalFavBooks'));

    }

    public function updateprofile(Request $request)
    {
        $userid = session('userid'); // cleaner syntax
        $user = usermodel::find($userid);
    
        if (!$user) {
            return redirect()->route('pages.userlogin')->with('error', 'User not found. Please log in again.');
        }
    
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'schoolid' => 'required|string|max:50',
            'course' => 'required|string|max:100',
            'birthdate' => 'required|date',
        ]);
    
        // Update profile
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->schoolid = $request->input('schoolid');
        $user->course = $request->input('course');
        $user->birthdate = $request->input('birthdate');
        $user->save();
    
        // Log out after update
        session()->flush();
        return redirect()->route('pages.userlogin')->with('success', 'Profile updated successfully. Please log in again.');
    }



//FAVORITES-----------------------------------------------------------------------------------------------------------------------------------------------------------
public function userfavorites(Request $request)
{
    $userId = $request->session()->get('userid');
    $user = Usermodel::find($userId);

    if (!$user) {
        return redirect()->route('pages.userlogin')->with('error', 'User not found.');
    }

    $ebooks = $user->favorites()->get();

    return view('pages.userfavorites', compact('ebooks'));
}

public function toggleFavorite(Request $request, BooksModel $ebook)
{
    $userId = $request->session()->get('userid');
    $user = Usermodel::find($userId);

    if (!$user) {
        return redirect()->route('pages.userlogin')->with('error', 'You need to log in to favorite an ebook.');
    }

    $favorite = FavModel::where('user_id', $userId)->where('ebook_id', $ebook->id)->first();

    if ($favorite) {
        $favorite->delete(); // Unfavorite
    } else {
        FavModel::create([
            'user_id' => $userId,
            'ebook_id' => $ebook->id
        ]);
    }

    return back();
}

public function favstore(Request $request)
{
    if (!$request->session()->has('userid')) {
        return redirect()->route('pages.userlogin')->with('error', 'Please log in to add favorites.');
    }

    $userId = $request->session()->get('userid');

    $request->validate([
        'ebook_id' => 'required|exists:books,id',
    ]);

    $existing = FavModel::where('user_id', $userId)
                        ->where('ebook_id', $request->ebook_id)
                        ->first();

    if ($existing) {
        return redirect()->back()->with('info', 'This book is already in your favorites.');
    }

    FavModel::create([
        'user_id' => $userId,
        'ebook_id' => $request->ebook_id,
    ]);

    return back()->with('success', 'Book added to favorites.');
}

public function myFavorites(Request $request)
{
    $userId = $request->session()->get('userid');

    $ebooks = booksmodel::whereIn('id', function($query) use ($userId) {
        $query->select('ebook_id')
              ->from('favmodels')
              ->where('user_id', $userId);
    })->get();

    return view('pages.myfavorites', compact('ebooks'));
}


public function userPage($section) {
    $views = [
        'ebook' => 'pages.ebook',
        'favorites' => 'pages.favorites',
        'profile' => 'pages.profile',
    ];

    if (!array_key_exists($section, $views)) {
        abort(404);
    }

    $data = [];

    if ($section === 'ebook') {
        $data['ebooks'] = booksmodel::all();
    }

    return view($views[$section], $data);
}

public function showUserBookPage()
{
    $departments = departmentmodel::all();
    $ebooks = booksmodel::all(); // or filter as needed

    return view('pages.userebook', compact('departments', 'ebooks'));
}



}