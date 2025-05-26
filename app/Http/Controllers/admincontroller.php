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
            'firstname'  => 'required',
            'middlename' => 'required',
            'lastname'   => 'required',
            'schoolid'   => 'required',
            'masterkey'  => 'required',
            'birthdate'  => 'required',
        ]);
    
        adminmodel::create([
            'firstname'  => $request->firstname,
            'middlename' => $request->middlename,
            'lastname'   => $request->lastname,
            'schoolid'   => $request->schoolid,
            'masterkey'  => Hash::make($request->masterkey),
            'birthdate'  => $request->birthdate,
        ]);
    
        return redirect()->route('admin.adminlogin')->with('success', 'Registration successful.');
    }
    
    //DASHBOARD-----------------------------------------------------------------------------------------------------------------
    public function dashboard() {
        return view('admin.admindashboard');
    }
//-------------------------------------------------------------------------------------------------------------------------------------------------

//BOOKS
public function add_new_books()
{
    $departments = departmentmodel::all(); // or however you're getting departments
    return view('admin.add_new_books', compact('departments'));
}



    public function storebooks(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'year' => 'required|integer',
            'category' => 'required|string',
            'department' => 'required|string',
            'pdf_filepath' => 'required|file|mimes:pdf',

        ]);
    
        if ($request->hasFile('pdf_filepath')) {
            $validatedData['pdf_filepath'] = $request->file('pdf_filepath')->store('octabooks', 'public');
        }
    
  
        $ebook = booksmodel::create($validatedData);
    
        if (strtolower($validatedData['category']) === 'graduate') {
            return redirect()->route('admin.graduate')->with('success', 'Graduate book uploaded successfully.');
        } elseif (strtolower($validatedData['category']) === 'under-graduate') {
            return redirect()->route('admin.undergraduate')->with('success', 'Undergraduate book uploaded successfully.');
        } elseif (strtolower($validatedData['category']) === 'employee') {
            return redirect()->route('admin.employeebook')->with('success', 'Undergraduate book uploaded successfully.');
        } else {
            return redirect()->back()->with('success', 'Book uploaded, but category is unrecognized.');
        }
    }
    
    public function departmentBooks(Request $request)
    {
        $departments = departmentmodel::all();
    
        return view('admin.add_new_books', compact( 'departments'));
    }
    
    public function dept()
    {
        return $this->belongsTo(departmentmodel::class, 'department_id', 'id');
    }


//-------------------------------------------------------------------------------------------------------------------------------------------------

//GRADUATE    
    public function graduate_table()
    {
        return view('admin.graduate');
    }

  
    public function graduateBooks(Request $request)
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
    

        $booksmodel = $query->where('category', 'Graduate')->get();
        $countgrads = $booksmodel->count();
    
        return view('admin.graduate', compact('booksmodel', 'countgrads', 'departments'));
    }
    


    public function depts()
    {
        return $this->belongsTo(departmentmodel::class, 'department_id', 'department');
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
    


    public function dprtmnt()
    {
        return $this->belongsTo(departmentmodel::class, 'department_id', 'department');
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



public function depty()
{
    return $this->belongsTo(departmentmodel::class, 'department_id', 'department');
}


//-------------------------------------------------------------------------------------------------------------------------------------------------

//GRADUATE AND UNDERGRADUATE (EDIT AND DELETE)

public function deletebook(Request $request, $id) {
    $book = booksmodel::find($id);

    $categoryType = strtolower($request->input('category', 'graduate')); 

    if (!$book) {
        if ($categoryType === 'undergraduate') {
            return redirect()->route('admin.undergraduate')->with('error', 'Book not found.');
        } else {
            return redirect()->route('admin.graduate')->with('error', 'Book not found.');
        }
    }

    $book->delete();

    if (strtolower($book->category) === "graduate") {
        return redirect()->route('admin.graduate')->with('success', 'Book deleted successfully.');
    } else {
        return redirect()->route('admin.undergraduate')->with('success', 'Book deleted successfully.');
    }
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

    if (strtolower($book->category) === "graduate") {
        return redirect()->route('admin.graduate')->with('success', 'Book updated successfully.');
    } elseif (strtolower($book->category) === "employee") {
        return redirect()->route('admin.employeebook')->with('success', 'Book updated successfully.');
    } else {
        return redirect()->route('admin.undergraduate')->with('success', 'Book updated successfully.');
    }
    

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
    





//COURSE-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function course()
{
return view ('admin.setup.course');
}

public function storecourse(Request $request)
{
    $data = $request->validate([
        'course'  => 'required',
    ]);
    $newcourse = coursemodel::create($data); 
    return redirect(route('admin.setup.course'));
}


public function deletecourse($id)
{
    $dept = coursemodel::findOrFail($id);
    $dept->delete(); 

    return redirect()->back()->with('success', 'Course deleted successfully!');
}

public function editcourse($id){

    $task = coursemodel::find($id);
    return view('admin.setup.course', compact('course'));
    }
    
    public function updatecourse(Request $request, $id) {
        $request->validate([
            'course' => 'required|min:1|max:255|alpha',
        ]);
    
         $post = coursemodel::find($id);
         $post->fill($request->all());
         $post->save();
        return redirect()->route('admin.setup.course');
    }
    

    public function searchCourse(Request $request)
    {
        $courses = coursemodel::all();
    
        $query = coursemodel::query();
    
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('course', 'like', '%' . $request->search . '%')
                  ->orWhere('created_at', 'like', '%' . $request->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $request->search . '%');
            });
        }
    
        $coursemodel = $query->get();
    
        return view('admin.setup.course', compact('coursemodel', 'courses'));
    }


//CAROUSEL-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function carousel()
{
return view ('admin.setup.carousel');
}

public function showcarousel()
{
    $carouselmodel = carouselmodel::all();
    return view('admin.setup.carousel')->with('carouselmodel', $carouselmodel);

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
            'position' => 'required|min:1|max:255|alpha',
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
    
        $positionmodel = $query->get();
    
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
    
    public function mmbrs()
    {
        return $this->belongsTo(positionmodel::class, 'position_id', 'position');
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//PIECHART----------------------------------------------------------------------------------------------------------------
public function admingraphs()
{
    // by category------------------------------------------------------------------------------------
    $graduateCount = BooksModel::where('category', 'Graduate')->count();
    $underGraduateCount = BooksModel::where('category', 'Under-Graduate')->count();
    $employeeCount = BooksModel::where('category', 'Employee')->count();
    $pieData = [
        'labels' => ['Graduate', 'Under-Graduate', 'Employee'],
        'values' => [$graduateCount, $underGraduateCount, $employeeCount ]
    ];

    // by department------------------------------------------------------------------------------------
    $departments = BooksModel::select('department')
        ->groupBy('department')
        ->pluck('department');

    $counts = BooksModel::selectRaw('department, COUNT(*) as count')
        ->groupBy('department')
        ->pluck('count');

    $barDatabydept = [
        'labels' => $departments,
        'values' => $counts
    ];

        // by year-----------------------------------------------------------------------------------
        $years = BooksModel::select('year')
        ->groupBy('year')
        ->pluck('year');

    $counts = BooksModel::selectRaw('year, COUNT(*) as count')
        ->groupBy('year')
        ->pluck('count');

    $barDatabyyr = [
        'labels' => $years,
        'values' => $counts
    ];


     // by graddept-----------------------------------------------------------------------------------
     $barDatabyGraduateDept = BooksModel::selectRaw('department, COUNT(*) as count')
     ->where('category', 'graduate')
     ->groupBy('department')
     ->pluck('count', 'department'); // returns key-value pair like ['CS' => 5, 'IT' => 7]
 
     $bygradDeptChart = [
        'labels' => $barDatabyGraduateDept->keys()->toArray(),
        'values' => $barDatabyGraduateDept->values()->toArray()
    ];
    
      // by undergraddept-----------------------------------------------------------------------------------
      $barDatabyUnderGraduateDept = BooksModel::selectRaw('department, COUNT(*) as count')
      ->where('category', 'Under-Graduate')
      ->groupBy('department')
      ->pluck('count', 'department'); // returns key-value pair like ['CS' => 5, 'IT' => 7]
  
      $byundergradDeptChart = [
         'labels' => $barDatabyUnderGraduateDept->keys()->toArray(),
         'values' => $barDatabyUnderGraduateDept->values()->toArray()
     ];
     
          // by employeedept-----------------------------------------------------------------------------------
          $barDatabyEmpDept = BooksModel::selectRaw('department, COUNT(*) as count')
          ->where('category', 'employee')
          ->groupBy('department')
          ->pluck('count', 'department'); // returns key-value pair like ['CS' => 5, 'IT' => 7]
      
          $byempDeptChart = [
             'labels' => $barDatabyEmpDept->keys()->toArray(),
             'values' => $barDatabyEmpDept->values()->toArray()
         ];

// Fetch the categories (or any other column you're grouping by) for the x-axis of the bar chart
$bookcount = BooksModel::select('category')  // Change 'category' to the column you want to group by
    ->groupBy('category')  // Group by the column
    ->pluck('category');

// Count the number of books in each category (or group)
$counts = BooksModel::selectRaw('COUNT(*) as count')
    ->groupBy('category')  // Group by the same column as before
    ->pluck('count');

// Prepare the bar chart data
$barDataofbooks = [
    'labels' => $bookcount,  // The x-axis values (categories)
    'values' => $counts      // The y-axis values (book counts)
];

$totalBooks = BooksModel::count();[
    'totalBooks' => $totalBooks,
];

    
    return view('admin.admindashboard', compact(
        'pieData',
        'barDatabydept',
        'barDatabyyr',
        'bygradDeptChart', 'byundergradDeptChart', 'byempDeptChart', 'totalBooks',
    ));

    
}


}


