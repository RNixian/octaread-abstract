<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Models\adminmodel; 
use App\Models\booksmodel; 
use App\Models\favmodel;
use App\Models\viewsmodel;
use App\Models\carouselmodel; 
use App\Models\contactmodel; 
use App\Models\usertypemodel; 
use App\Models\userdeptmodel;
use App\Models\departmentmodel; 
use App\Models\rocmodel; 
use App\Models\underrocmodel; 
use App\Models\membersModel; 
use App\Models\usermodel; 
use App\Models\positionmodel; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Guard;


class admincontroller extends Controller
{

//-------------------------------------------------------------------------------------------------------------------------------------------------

    //ACCOUNT LOGIN---------------------------------------------------------------------------------------------------------------------
    public function adminloginview()
    {
        return view('admin.adminlogin');
    }

   public function adminlogin(Request $request)
{
    $request->validate([
        'schoolid' => 'required',
        'birthdate' => 'required|date',
        'masterkey' => 'required',
    ]);

    $admin = adminmodel::where('schoolid', $request->schoolid)
        ->where('birthdate', $request->birthdate)
        ->first();

    if ($admin && Hash::check($request->masterkey, $admin->masterkey)) {
        $admin->status = 'active';
        $admin->save();

        session([
            'adminid' => $admin->id,
            'firstname' => $admin->firstname,
            'role' => $admin->role // 👈 Add this line
        ]);

        return redirect()->route('admin.admindashboard');
    } else {
        return back()->withErrors(['Invalid School ID or Birthdate or MasterKey']);
    }
}

    public function logout(Request $request) {

        $adminid = session('adminid');
        if ($adminid) {
            $admin = adminmodel::find($adminid);
            if ($admin) {
                $admin->status = 'inactive';
                $admin->save();
            }
        }
    
        session()->flush(); // Clear all session data
        return redirect()->route('admin.adminlogin')->with('success', 'You have been logged out.');

    }


    //ACCOUNT REGISTER---------------------------------------------------------------------------------------------------------------------
    public function adminregister()
    {
        return view('admin.adminregister');
    }

    public function storenewadmin(Request $request)
    {
        $data = $request->validate([
            'firstname'  => 'required|string',
            'middlename' => 'nullable|string',
            'lastname'   => 'required|string',
            'schoolid'   => 'required|max:9|unique:admins,schoolid',
            'masterkey' => 'required|string|max:255',
            'birthdate'  => 'required|date',
        ]);
    
    
        adminmodel::create([
            'firstname'  => $request->firstname,
            'middlename' => $request->middlename,
            'lastname'   => $request->lastname,
            'schoolid'   => $request->schoolid,
            'masterkey'  => Hash::make($request->masterkey),
            'birthdate'  => $request->birthdate,
            'role'       => 'admin',
        ]);
    
        return redirect()->route('admin.adminlogin')->with('success', 'Registration successful.');
    }
    

//-------------------------------------------------------------------------------------------------------------------------------------------------

//BOOKS
public function add_new_books()
{
    $departments = departmentmodel::all(); // or however you're getting departments
    $res_out_cats = rocmodel::all();
    return view('admin.add_new_books', compact('departments', 'res_out_cats'));
}

public function storebooks(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string',
        'author' => 'required|string',
        'year' => 'required|integer',
        'category' => 'required|string',
        'department' => 'required|string',
        'pdf_filepath' => 'required|file|mimes:pdf,doc,docx',

    ]);

    $file = $request->file('pdf_filepath');
    // Save file directly without conversion
    $path = $file->store('octabooks', 'public');
    $validatedData['pdf_filepath'] = $path;

    booksmodel::create($validatedData);

    return redirect()->route('admin.graduate')->with('success', 'Book successfully added.');
}


    public function departmentBooks(Request $request)
    {
        $departments = departmentmodel::all();
    
        return view('admin.add_new_books', compact( 'departments'));
    }
    
    public function getDepartments($out_cat)
    {
        // First, find the category's ID
        $category = rocmodel::where('out_cat', $out_cat)->first();
    
        if (!$category) {
            return response()->json([]);
        }
    
        // Then get all departments under that category
        $departments = underrocmodel::where('out_cat_id', $category->id)->pluck('under_roc');
    
        return response()->json($departments);
    }



//-------------------------------------------------------------------------------------------------------------------------------------------------

//GRADUATE    
public function graduate_table()
{
    return view('admin.graduate');
}

public function graduateBooks(Request $request)
{
    // Fetch filters and supporting data
    $under_res_out_cats = underrocmodel::all();
    $res_out_cats = rocmodel::all();

    // Get distinct 'out_cat' values
    $categories = $res_out_cats->pluck('out_cat')->unique()->values();

    // Main query
    $query = booksmodel::query();

    // Apply search filters
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('author', 'like', '%' . $request->search . '%')
              ->orWhere('year', 'like', '%' . $request->search . '%')
              ->orWhere('department', 'like', '%' . $request->search . '%')
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
    if ($request->filled('out_cat')) {
        $query->where('category', $request->out_cat);
    }

    // Paginate results
    $books = $query->paginate(10)->withQueryString();
    $countgrads = $query->count(); // Count total matching

    return view('admin.graduate', compact(
        'books',
        'countgrads',
        'under_res_out_cats',
        'res_out_cats',
        'categories'
    ));
}

    

    public function gettingDepartments($out_cat)
    {
        $departments = rocmodel::where('out_cat', $out_cat)
                        ->distinct()
                        ->pluck('department');
    
        return response()->json($departments);
    }
    
    public function deletebook($id) {
        $book = booksmodel::find($id);
    
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found.');
        }
    
        $book->delete();
    
        return redirect()->back()->with('success', 'Book deleted successfully.');
    }
    
    public function editbook($id)
{
    $book = booksmodel::find($id);

    if (!$book) {
        return redirect()->route('admin.graduate')->with('error', 'Book not found.');
    }

    return view('admin.graduate', compact('book'));
}

        
    public function updatebook(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer',
            'category' => 'nullable|string',
            'department' => 'nullable|string',
            'pdf_filepath' => 'nullable|file|mimes:pdf',  // allow updating PDF if provided
    
        ]);
    
        $book = booksmodel::find($id);
    
        if (!$book) {
            return redirect()->route('admin.graduate')->with('error', 'Book not found.');
        }
        if ($request->hasFile('pdf_filepath')) {
            $book->pdf_filepath = $request->file('pdf_filepath')->store('octabooks', 'public');
        }
        $book->update($request->only(['title', 'author', 'year', 'category', 'department']));

        return redirect()->route('admin.graduate')->with('success', 'Book updated successfully.');
        
    }



//-------------------------------------------------------------------------------------------------------------------------------------------------

//UNDERGRADUATE
    public function undergraduate_table()
    {
        return view('admin.undergraduate');
    }

    public function undergraduateBooks(Request $request)
    {
        $departments = departmentmodel::all();
    
        $query = booksmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%')
                  ->orWhere('year', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%')
                  ->orWhere('pdf_filepath', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('department') && $request->department) {
            $query->where('department', $request->department);
        }
    
        $booksmodel = $query->where('category', 'Under-Graduate')->get();
        $undercountgrads = $booksmodel->count();
    
    
        return view('admin.undergraduate', compact('booksmodel','undercountgrads', 'departments'));
    }
    
//-------------------------------------------------------------------------------------------------------------------------------------------------

//EMPLOYEE
public function employee_table()
{
    return view('admin.employeebook');
}

public function employeeBooks(Request $request)
{
    $departments = departmentmodel::all();

    $query = booksmodel::query();

    if ($request->has('search') && $request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('author', 'like', '%' . $request->search . '%')
              ->orWhere('year', 'like', '%' . $request->search . '%')
              ->orWhere('department', 'like', '%' . $request->search . '%')
              ->orWhere('pdf_filepath', 'like', '%' . $request->search . '%')
              ->orWhere('created_at', 'like', '%' . $request->search . '%')
              ->orWhere('updated_at', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('department') && $request->department) {
        $query->where('department', $request->department);
    }

    $booksmodel = $query->where('category', 'Employee')->get();
    $employeebookcount = $booksmodel->count();


    return view('admin.employeebook', compact('booksmodel','employeebookcount', 'departments'));
}

//-------------------------------------------------------------------------------------------------------------------------------------------------
//SIDEBAR    
public function adminsidebar()
{
return view ('admin.sidebar');
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//SETUP
//DEPARMENT-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
public function department()
{
return view ('admin.setup.department');
}

public function storedepartment(Request $request)
{
    $data = $request->validate([
        'department'  => 'required',

    ]);
    $newdept = departmentmodel::create($data); 
    return redirect(route('admin.setup.department'));
    
}
public function showdepartment()
{
    $departmentmodel = departmentmodel::all();
    return view('admin.setup.department')->with('departmentmodel', $departmentmodel);

}


public function deletedept($id)
{
    $dept = departmentmodel::findOrFail($id);
    $dept->delete(); 

    return redirect()->back()->with('success', 'Department deleted successfully!');
}

public function editdept($id){

    $task = departmentmodel::find($id);
    return view('admin.setup.department', compact('department'));
    }
    
    public function updatedept(Request $request, $id) {
        $request->validate([
            'department' => 'required|min:1|max:255|alpha',
        ]);
    
         $post = departmentmodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.department');
    }
    
    

    public function searchDept(Request $request)
    {
        $departments = departmentmodel::all();
    
        $query = departmentmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('department', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        $departmentmodel = $query->get();
    
        return view('admin.setup.department', compact('departmentmodel', 'departments'));
    }
    



/*

//PROGRAM-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
public function program()
{
return view ('admin.setup.program');
}

public function storeprogram(Request $request)
{
    $data = $request->validate([
        'program'  => 'required',
    ]);
    $newprogram = programmodel::create($data); 
    return redirect(route('admin.setup.program'));
}


public function deleteprogram($id)
{
    $dept = programmodel::findOrFail($id);
    $dept->delete(); 

    return redirect()->back()->with('success', 'Program deleted successfully!');
}

public function editprogram($id){

    $task = programmodel::find($id);
    return view('admin.setup.program', compact('program'));
    }
    
    public function updateprogram(Request $request, $id) {
        $request->validate([
            'program' => 'required|min:1|max:255|alpha',
        ]);
    
         $post = programmodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.program');
    }
    

    public function searchprogram(Request $request)
    {
        $programs = programmodel::all();
    
        $query = programmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('program', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        $programmodel = $query->get();
    
        return view('admin.setup.program', compact('programmodel', 'programs'));
    }

//PROGRAMPLUS----------------------------------------------------------------------------------------------------------------------------------------------------------

public function programplus()
{
return view ('admin.setup.programplus');
}

public function storeprogramplus(Request $request)
{
    $data = $request->validate([
        'programplus'  => 'required',
    ]);
    $newprogramplus = programplusmodel::create($data); 
    return redirect(route('admin.setup.programplus'));
}


public function deleteprogramplus($id)
{
    $plus = programplusmodel::findOrFail($id);
    $plus->delete(); 

    return redirect()->back()->with('success', 'Program deleted successfully!');
}

public function editprogramplus($id){

    $task = programplusmodel::find($id);
    return view('admin.setup.programplus', compact('programplus'));
    }
    
    public function updateprogramplus(Request $request, $id) {
        $request->validate([
            'programplus' => 'required|min:1|max:255|alpha',
        ]);
    
         $post = programplusmodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.programplus');
    }
  
    public function searchprogramplus(Request $request)
    {
        $programpluss = programplusmodel::all();
    
        $query = programplusmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('programplus', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        $programplusmodel = $query->get();
    
        return view('admin.setup.programplus', compact('programplusmodel', 'programpluss'));
    }
*/
//CAROUSEL-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function carousel()
{
return view ('admin.setup.carousel');
}

public function showcarousel()
{
    $carouselmodel = carouselmodel::paginate(3)->withQueryString();
    return view('admin.setup.carousel', compact('carouselmodel'));


}

public function storecarousel(Request $request)
{
    $validatedData = $request->validate([
        'carousel_imgpath' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        'display_order' => 'required|int',

    ]);

    if ($request->hasFile('carousel_imgpath')) {
        $validatedData['carousel_imgpath'] = $request->file('carousel_imgpath')->store('octacarousel', 'public');
    }
    $carousel = carouselmodel::create($validatedData);
    return redirect()->route('admin.setup.carousel')->with('success', 'Carousel uploaded successfully.');

}

public function deletecarousel($id)
{
    $carousel = carouselmodel::findOrFail($id);
    $carousel->delete(); 

    return redirect()->back()->with('success', 'Carousel deleted successfully!');
}

public function updatecarousel(Request $request, $id) {
    $request->validate([
        'carousel_imgpath' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        'display_order' => 'required|int|max:255',
 
    ]);

    $carousel = carouselmodel::find($id);

    if (!$carousel) {
        return redirect()->route('admin.setup.carousel')->with('error', 'Carousel not found.');
    }

    if ($request->hasFile('carousel_imgpath')) {
        $carousel->carousel_imgpath = $request->file('carousel_imgpath')->store('octacarousel', 'public');
    }

    $carousel->update($request->only(['display_order']));
        return redirect()->route('admin.setup.carousel')->with('success', 'Carousel updated successfully.');
   
}

//RESEARCH OUTPUT CATEGORIES----------------------------------------------------------------------------------------------------------------------

public function resoutcat()
{
return view ('admin.setup.resoutcat');
}

public function storeout_cat(Request $request)
{
    $data = $request->validate([
        'out_cat'  => 'required',

    ]);
    $newout_cat = rocmodel::create($data); 
    return redirect(route('admin.setup.resoutcat'));
}


public function deleteout_cat($id)
{
    $out_cat = rocmodel::findOrFail($id);
    $out_cat->delete(); 

    return redirect()->back()->with('success', 'Output Category has been deleted successfully!');
}

public function editout_cat($id){

    $out_cat = rocmodel::find($id);
    return view('admin.setup.resoutcat', compact('out_cat'));
    }
    
    public function updateout_cat(Request $request, $id) {
        $request->validate([
            'out_cat' => 'required|min:1|max:255',
        ]);
    
         $post = rocmodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.resoutcat');
    }

    public function searchout_cat(Request $request)
    {
        $out_cats = rocmodel::all();
    
        $query = rocmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('out_cat', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        $rocmodel = $query->paginate(5)->withQueryString();
    
        return view('admin.setup.resoutcat', compact('rocmodel', 'out_cats'));
    }

//UNDER RESEARCH OUTPUT CATEGORIES----------------------------------------------------------------------------------------------------------------------

public function underresoutcat()
{
    return view ('admin.setup.under_out_cat');
}

public function storeunder_out_cat(Request $request)
{
    $data = $request->validate([
        'out_cat_id' => 'required|exists:research_out_cat,id',
        'under_roc'  => 'required|string|max:255',

    ]);
    $new_under_out_cat = underrocmodel::create($data); 
    return redirect(route('admin.setup.under_out_cat'));
}


public function deleteunder_out_cat($id)
{
    $under_out_cat = underrocmodel::findOrFail($id);
    $under_out_cat->delete(); 

    return redirect()->back()->with('success', 'Under Output Category has been deleted successfully!');
}

public function editunder_out_cat($id){

    $under_out_cat = underrocmodel::find($id);
    return view('admin.setup.under_out_cat', compact('under_out_cat'));
    }
    
    public function updateunder_out_cat(Request $request, $id) {
        $request->validate([
            'out_cat_id' => 'required|exists:research_out_cat,id',
            'under_roc'  => 'required|string|max:255',
        ]);
    
         $post = underrocmodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.under_out_cat');
    }


public function searchunder_out_cat(Request $request)
{
    $under_out_cats = underrocmodel::all();
    $res_out_category = rocmodel::all();

    $query = underrocmodel::with('outputCategory'); // eager load relationship

    if ($request->has('search') && $request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('under_roc', 'like', '%' . $request->search . '%')
              ->orWhere('created_at', 'like', '%' . $request->search . '%')
              ->orWhere('updated_at', 'like', '%' . $request->search . '%');
        })->orWhereHas('outputCategory', function ($q) use ($request) {
            $q->where('out_cat', 'like', '%' . $request->search . '%');
        });
    }

    $underrocmodel = $query->paginate(5)->withQueryString();

    return view('admin.setup.under_out_cat', compact('underrocmodel', 'under_out_cats', 'res_out_category'));
}


 //USER ACCESS----------------------------------------------------------------------------------------------------------------------

 public function usertype()
 {
 return view ('admin.setup.usertype');
 }

 public function userdept()
 {
 return view ('admin.setup.userdepartment');
 }

    //STORE-------------------------------------------------------------------------------

 public function storeusertype(Request $request)
 {
     $data = $request->validate([
         'user_type'  => 'required',
 
     ]);
     $newusertype = usertypemodel::create($data); 
     return redirect(route('admin.setup.usertype'));
 }
 
 public function storeuserdept(Request $request)
 {
     $data = $request->validate([
        'user_type_id' => 'required|exists:usertype,id',
         'user_department'  => 'required',
     ]);
     $newuserdept = userdeptmodel::create($data); 
     return redirect(route('admin.setup.userdepartment'));
 }

   //DELETE-------------------------------------------------------------------------------

 public function deleteusertype($id)
 {
     $usertype = usertypemodel::findOrFail($id);
     $usertype->delete(); 
 
     return redirect()->back()->with('success', 'UserType deleted successfully!');
 }
 
 public function deleteuserdept($id)
 {
     $userdept = userdeptmodel::findOrFail($id);
     $userdept->delete(); 
 
     return redirect()->back()->with('success', 'UserType deleted successfully!');
 }

   //EDIT-------------------------------------------------------------------------------

 public function editusertype($id){
 
     $usertype = usertypemodel::find($id);
     return view('admin.setup.usertype', compact('usertype'));
     }

public function edituserdept($id){
 
    $userdept = userdeptmodel::find($id);
    return view('admin.setup.userdepartment', compact('userdept'));
    }

     
   //UPDATE-------------------------------------------------------------------------------

     public function updateusertype(Request $request, $id) {
         $request->validate([
             'user_type' => 'required|min:1|max:255',
         ]);
     
          $post = usertypemodel::find($id);
          $post->fill($request->all());
          $post->save();
         return redirect()->route('admin.setup.usertype');
     }

     public function updateuserdept(Request $request, $id) {
        $request->validate([
            'user_type_id' => 'required|exists:usertype,id',
            'user_department' => 'required|min:1|max:255',
        ]);
    
         $post = userdeptmodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.userdepartment');
    }
 
   //SEARCH-------------------------------------------------------------------------------

     public function searchusertype(Request $request)
     {
         $usertypes = usertypemodel::all();
     
         $query = usertypemodel::query();
     
         if ($request->has('search') && $request->search) {
             $query->where(function ($q) use ($request) {
                 $q->where('user_type', 'like', '%' . $request->search . '%')
                   ->orWhere('created_at', 'like', '%' . $request->search . '%')
                   ->orWhere('updated_at', 'like', '%' . $request->search . '%');
             });
         }
     
         $usertypemodel = $query->paginate(5)->withQueryString();
         return view('admin.setup.usertype', compact('usertypemodel', 'usertypes'));
     }
 
 public function searchuserdept(Request $request)
{
    $userdepts = userdeptmodel::all();
    $usertypes = usertypemodel::all();

    // Eager load relationship
    $query = userdeptmodel::with('userTypes'); // replace 'usertype' with actual relationship method name

    if ($request->has('search') && $request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('user_department', 'like', '%' . $request->search . '%')
              ->orWhere('created_at', 'like', '%' . $request->search . '%')
              ->orWhere('updated_at', 'like', '%' . $request->search . '%');
        })->orWhereHas('userTypes', function ($q) use ($request) {
            $q->where('user_type', 'like', '%' . $request->search . '%'); // adjust column name as needed
        });
    }

    $userdeptmodel = $query->paginate(5)->withQueryString();

    return view('admin.setup.userdepartment', compact('userdeptmodel', 'userdepts', 'usertypes'));
}




     


    //POSITION----------------------------------------------------------------------------------------------------------------------

    public function position()
    {
    return view ('admin.setup.position');
    }
    
    public function storeposition(Request $request)
    {
        $data = $request->validate([
            'position'  => 'required',
    
        ]);
        $newposition = positionmodel::create($data); 
        return redirect(route('admin.setup.position'));
    }
    
    
    public function deleteposition($id)
    {
        $position = positionmodel::findOrFail($id);
        $position->delete(); 
    
        return redirect()->back()->with('success', 'Position deleted successfully!');
    }
    
    public function editposition($id){
    
        $position = positionmodel::find($id);
        return view('admin.setup.position', compact('position'));
        }
        
        public function updateposition(Request $request, $id) {
            $request->validate([
                'position' => 'required|min:1|max:255',
            ]);
        
             $post = positionmodel::find($id);
             $post->fill($request->all());
             $post->save();
            return redirect()->route('admin.setup.position');
        }
    
        public function searchPosition(Request $request)
        {
            $positions = positionmodel::all();
        
            $query = positionmodel::query();
        
            if ($request->has('search') && $request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('position', 'like', '%' . $request->search . '%')
                      ->orWhere('created_at', 'like', '%' . $request->search . '%')
                      ->orWhere('updated_at', 'like', '%' . $request->search . '%');
                });
            }
        
            $positionmodel = $query->paginate(5)->withQueryString();
        
            return view('admin.setup.position', compact('positionmodel', 'positions'));
        }
    


    
//-------------------------------------------------------------------------------------------------------------------------------------------------

//MEMBERS
public function employee()
{
    return view('admin.member');
}


public function storemember(Request $request)
{
    $validatedData = $request->validate([
        'fullname' => 'required|string',
        'position' => 'required|string',
        'profile_imgpath' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
    ]);

    if ($request->hasFile('profile_imgpath')) {
        $validatedData['profile_imgpath'] = $request->file('profile_imgpath')->store('octamember', 'public');
    }
    $member = membersmodel::create($validatedData);
    return redirect()->route('admin.member')->with('success', 'Member uploaded successfully.');

}

public function deletemember($id)
{
    $member = membersmodel::findOrFail($id);
    $member->delete(); 

    return redirect()->back()->with('success', 'Member deleted successfully!');
}

public function updatemember(Request $request, $id) {
    $request->validate([
        'fullname' => 'required|string',
        'position' => 'required|string',
        'profile_imgpath' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
 
    ]);

    $member = membersmodel::find($id);

    if (!$member) {
        return redirect()->route('admin.member')->with('error', 'Member not found.');
    }

    if ($request->hasFile('profile_imgpath')) {
        $member->profile_imgpath = $request->file('profile_imgpath')->store('octamember', 'public');
    }

    $member->update($request->only(['fullname', 'position']));
        return redirect()->route('admin.member')->with('success', 'Member updated successfully.');
   
}

public function searchMember(Request $request)
    {
        $positions = positionmodel::all();
    
        $query = membersmodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->search . '%')
                  ->orWhere('position', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('position') && $request->position) {
            $query->where('position', $request->position);
        }
    
        $membersmodel = $query->get();
    
        return view('admin.member', compact('membersmodel', 'positions'));
    }
    

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
public function admingraphs(Request $request)
{
    // Get filter values
    $selectedCategory = $request->input('category');
    $selectedDepartment = $request->input('department');
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $search = $request->input('search');
    // Base query
    $query = BooksModel::query();


// Filter by search keyword on year, category, or department columns
if ($search) {
    $query->where(function($q) use ($search) {
        $q->where('year', 'like', "%{$search}%")
          ->orWhere('category', 'like', "%{$search}%")
          ->orWhere('department', 'like', "%{$search}%");
    });
}

    if ($selectedCategory) {
        $query->where('category', $selectedCategory);
    }

    if ($selectedDepartment) {
        $query->where('department', $selectedDepartment);
    }

    if ($fromDate && $toDate) {
        $query->whereBetween('created_at', [$fromDate, $toDate]);
    } elseif ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    } elseif ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    // Get data for filtered bar chart (grouped by year)
    $filteredBooks = $query->select('year')->groupBy('year')->pluck('year');
    $filteredCounts = $query->selectRaw('year, COUNT(*) as count')->groupBy('year')->pluck('count');

    // Category Dropdown (for pie chart)
    $categories = RocModel::pluck('out_cat')->unique()->values();
    $departments = BooksModel::pluck('department')->unique()->values(); // Assuming this exists

    // Pie Chart (overall stats per category)
    $labels = [];
    $values = [];

    foreach ($categories as $category) {
        $labels[] = $category;
        $values[] = BooksModel::where('category', $category)->count();
    }

    $pieData = [
        'labels' => $labels,
        'values' => $values,
    ];

    // Bar Chart (overall stats per year)
    $years = BooksModel::select('year')->groupBy('year')->pluck('year');
    $counts = BooksModel::selectRaw('year, COUNT(*) as count')->groupBy('year')->pluck('count');

    $barDatabyyr = [
        'labels' => $years,
        'values' => $counts,
    ];

    $res_out_cats = RocModel::all();
    $totalBooks = BooksModel::count();
    $totalUser = usermodel::where('user_type_id', '!=', '0')->count();
    $totalGuest = usermodel::where('user_type_id', '==', '0')->count();
    $totalAdmin = adminmodel::count();
    $mostFavorite = favmodel::select('ebook_id')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('ebook_id')
    ->orderByDesc('total')
    ->first();

        $mostFavoriteTitle = null;
        $mostFavoriteCount = 0;

        if ($mostFavorite) {
            $book = booksmodel::where('id', $mostFavorite->ebook_id)->first();
            $mostFavoriteTitle = $book->title ?? 'Unknown Title';
            $mostFavoriteCount = $mostFavorite->total;
        }
       
    $mostViewed = viewsmodel::select('ebook_id')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('ebook_id')
    ->orderByDesc('total')
    ->first();
    
        $mostViewedTitle = null;
        $mostViewedCount = 0;
    
        if ($mostViewed) {
            $book = booksmodel::where('id', $mostViewed->ebook_id)->first();
            $mostViewedTitle = $book->title ?? 'Unknown Title';
            $mostViewedCount = $mostViewed->total;
        }
        

    

    return view('admin.admindashboard', compact(
        'pieData',
        'barDatabyyr',
        'totalBooks',
        'mostFavoriteTitle',
        'mostFavoriteCount',
        'mostViewedTitle',
        'mostViewedCount',
        'totalUser',
        'totalAdmin',
        'totalGuest',
        'categories',
        'departments',
        'res_out_cats',
        'filteredBooks',
        'filteredCounts',
        'selectedCategory',
        'selectedDepartment',
        'fromDate',
        'toDate'
    ));
}


public function getDeptgraph($out_cat)
{
    $category = RocModel::where('out_cat', $out_cat)->first();

    if (!$category) {
        return response()->json([]);
    }

    $departments = UnderRocModel::where('out_cat_id', $category->id)
        ->pluck('under_roc');

    return response()->json($departments);
}


public function getFilteredBooks(Request $request)
{
    $query = BooksModel::query();

    if ($request->category) {
        $category = RocModel::find($request->category);
        if ($category) {
            $query->where('out_cat_id', $category->id);
        }
    }

    if ($request->department) {
        $under = UnderRocModel::where('under_roc', $request->department)->first();
        if ($under) {
            $query->where('under_roc_id', $under->id);
        }
    }

    if ($request->from_date && $request->to_date) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    $results = $query->selectRaw('year, COUNT(*) as count')
        ->groupBy('year')
        ->pluck('count', 'year');

    return response()->json([
        'labels' => $results->keys(),
        'values' => $results->values(),
    ]);
}


}


