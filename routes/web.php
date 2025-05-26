<?php
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\adminmodel; 
use App\Models\usermodel; 

/**Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';**/




//ADMIN LOGIN----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/adminlogin', [admincontroller::class, 'adminloginview'])->name('admin.adminlogin');
Route::post('/admin/adminlogin', [admincontroller::class, 'adminlogin'])->name('admin.adminlogin');
Route::post('/logout', [admincontroller::class, 'logout'])->name('logout');
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/admindashboard', [admincontroller::class, 'dashboard'])->name('admin.admindashboard');
});

//ADMIN REGISTER-----------------------------------------------------------------------------------------------------------------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [admincontroller::class, 'adminregister'])->name('adminregister');
    Route::post('/store', [admincontroller::class, 'storenewadmin'])->name('storenewadmin');
});


Route::middleware(['admin.auth'])->group(function () {
//DASHBOARD----------------------------------------------------------------------------------------------------------------------------------------

Route::get('/admin/admindashboard', [AdminController::class, 'admingraphs'])->name('admin.admindashboard');

//BOOKS-----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/add_new_books', [admincontroller::class, 'add_new_books'])->name('admin.add_new_books');
Route::post('/admin/add_new_books', [admincontroller::class, 'storebooks'])->name('admin.storebooks');
//Route::get('/admin/add_new_books', [admincontroller::class, 'departmentBooks'])->name('admin.add_new_books');

//GRADUATE----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/graduate-table', [admincontroller::class, 'graduate_table'])->name('admin.graduate');
Route::get('/delete-book/{id}', [admincontroller::class, 'deletebook'])->name('deletebook');
Route::get('/edit-book/{id}', [admincontroller::class, 'editbook'])->name('editbook');
Route::put('/update-book/{id}', [admincontroller::class, 'updatebook'])->name('updatebook');
Route::get('/admin/graduate', [AdminController::class, 'graduateBooks'])->name('admin.graduate');

//GRADUATE----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/employee-table', [admincontroller::class, 'employee_table'])->name('admin.employeebook');
Route::get('/delete-book/{id}', [admincontroller::class, 'deletebook'])->name('deletebook');
Route::get('/edit-book/{id}', [admincontroller::class, 'editbook'])->name('editbook');
Route::put('/update-book/{id}', [admincontroller::class, 'updatebook'])->name('updatebook');
Route::get('/admin/employee', [AdminController::class, 'employeeBooks'])->name('admin.employeebook');


//UNDERGRADUATE-----------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/undergraduate-table', [admincontroller::class, 'undergraduate_table'])->name('admin.undergraduate');
Route::get('/delete-book/{id}', [admincontroller::class, 'deletebook'])->name('deletebook');
Route::get('/edit-book/{id}', [admincontroller::class, 'editbook'])->name('editbook');
Route::put('/update-book/{id}', [admincontroller::class, 'updatebook'])->name('updatebook');
Route::get('/admin/undergraduate', [AdminController::class, 'undergraduateBooks'])->name('admin.undergraduate');

//SIDEBAR-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/sidebar', [admincontroller::class, 'adminsidebar'])->name('admin.sidebar');

//DEPARTMENT-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/department', [admincontroller::class, 'department'])->name('admin.setup.department');
Route::post('/admin/setup/department', [admincontroller::class, 'storedepartment'])->name('admin.setup.storedepartment');
Route::get('/admin/setup/department', [admincontroller::class, 'searchDept'])->name('admin.setup.department');
Route::get('/delete-dept/{id}', [admincontroller::class, 'deletedept'])->name('deletedept');
Route::get('/edit-dept/{id}', [admincontroller::class, 'editdept'])->name('editdept');
Route::put('/update-dept/{id}', [admincontroller::class, 'updatedept'])->name('updatedept');

//COURSE-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/course', [admincontroller::class, 'course'])->name('admin.setup.course');
Route::post('/admin/setup/course', [admincontroller::class, 'storecourse'])->name('admin.setup.storecourse');
Route::get('/admin/setup/course', [admincontroller::class, 'searchCourse'])->name('admin.setup.course');
Route::get('/delete-course/{id}', [admincontroller::class, 'deletecourse'])->name('deletecourse');
Route::get('/edit-course/{id}', [admincontroller::class, 'editcourse'])->name('editcourse');
Route::put('/update-course/{id}', [admincontroller::class, 'updatecourse'])->name('updatecourse');

//CAROUSEL-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/carousel', [admincontroller::class, 'carousel'])->name('admin.setup.carousel');
Route::post('/admin/setup/carousel', [admincontroller::class, 'storecarousel'])->name('admin.setup.storecarousel');
Route::get('/admin/setup/carousel', [admincontroller::class, 'showcarousel'])->name('admin.setup.carousel');
Route::get('/delete-carousel/{id}', [admincontroller::class, 'deletecarousel'])->name('deletecarousel');
Route::get('/edit-carousel/{id}', [admincontroller::class, 'editcarousel'])->name('editcarousel');
Route::put('/update-carousel/{id}', [admincontroller::class, 'updatecarousel'])->name('updatecarousel');

//POSITION-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/position', [admincontroller::class, 'position'])->name('admin.setup.position');
Route::post('/admin/setup/position', [admincontroller::class, 'storeposition'])->name('admin.setup.storeposition');
Route::get('/admin/setup/position', [admincontroller::class, 'searchPosition'])->name('admin.setup.position');
Route::get('/delete-position/{id}', [admincontroller::class, 'deleteposition'])->name('deleteposition');
Route::get('/edit-position/{id}', [admincontroller::class, 'editposition'])->name('editposition');
Route::put('/update-position/{id}', [admincontroller::class, 'updateposition'])->name('updateposition');


//EMPLOYEE----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/add_new_employee', [admincontroller::class, 'employee'])->name('admin.member');
Route::post('/admin/memberregister', [admincontroller::class, 'storemember'])->name('admin.storemember');
Route::get('/delete-member/{id}', [admincontroller::class, 'deletemember'])->name('deletemember');
Route::get('/edit-member/{id}', [admincontroller::class, 'editmember'])->name('editmember');
Route::put('/update-member/{id}', [admincontroller::class, 'updatemember'])->name('updatemember');
Route::get('/admin/member', [AdminController::class, 'searchMember'])->name('admin.member');


});

//=================================================================================================================================================

//LOGIN-VIEW-----------------------------------------------------------------------------------------------------------------------
// LOGIN
Route::get('/pages/userlogin', [UserController::class, 'userloginview'])->name('pages.userlogin');
Route::post('/pages/userlogin', [UserController::class, 'userlogin'])->name('pages.userlogin');

// USER REGISTRATION
Route::get('/pages/registeruser', [UserController::class, 'registeruser'])->name('pages.registeruser');
Route::post('/pages/registeruser', [UserController::class, 'storeuser'])->name('pages.storeuser');


//-------------------------------------------------------------------------------------------------------------------------------------------
//PUBLIC
//--------------------------------------------------------------------------------------------------------------------------------------
// HEADER 
Route::get('/pages/usersheader', [UserController::class, 'usersheader'])->name('pages.usersheader');

// DASHBOARD

Route::get('/pages/userdashboard', [UserController::class, 'userdashboard'])->name('pages.userdashboard');

// LOGOUT USER
Route::post('/pages/logoutuser', [UserController::class, 'logoutuser'])->name('pages.logoutuser');

//-------------------------------------------------------------------------------------------------------------------------------------------
//PROTECTED
//--------------------------------------------------------------------------------------------------------------------------------------

// USERSLINK
Route::middleware(['account.auth'])->group(function () {

    // E-BOOK
    Route::get('/pages/ebook', [UserController::class, 'userebook'])->name('pages.ebook');

    // FAVORITES
    Route::get('/pages/favorites', [UserController::class, 'userfavorites'])->name('pages.favorites');
    Route::post('/toggle-favorite/{ebook}', [UserController::class, 'toggleFavorite'])->name('toggle.favorite');
    Route::post('/pages/favorites', [UserController::class, 'favstore'])->name('favorites.store')->middleware('account.auth');

    // PROFILE
    Route::get('/pages/profile', [UserController::class, 'userprofile'])->name('pages.profile');
    Route::post('/pages/profile', [UserController::class, 'updateprofile'])->name('pages.profile.update');

});









