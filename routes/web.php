<?php

use App\Http\Controllers\AccountController;
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
Route::middleware(['noadmins'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/register', [admincontroller::class, 'adminregister'])->name('adminregister');
        Route::post('/store', [admincontroller::class, 'storenewadmin'])->name('storenewadmin');
    });
});


Route::middleware(['admin.auth'])->group(function () {

//DASHBOARD----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/admindashboard', [AdminController::class, 'admingraphs'])->name('admin.admindashboard');
Route::get('/get-deptgraph/{id}', [AdminController::class, 'getDeptgraph']);
Route::get('/get-filtered-books', [AdminController::class, 'getFilteredBooks']);


//BOOKS-----------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/add_new_books', [admincontroller::class, 'add_new_books'])->name('admin.add_new_books');
Route::post('/admin/add_new_books', [admincontroller::class, 'storebooks'])->name('admin.storebooks');
Route::get('/get-departments/{out_cat}', [admincontroller::class, 'getDepartments']);

//GRADUATE----------------------------------------------------------------------------------------------------------------------------------------
// ONLY use this route
Route::get('/admin/graduate', [AdminController::class, 'graduateBooks'])->name('admin.graduate');
Route::get('/delete-book/{id}', [admincontroller::class, 'deletebook'])->name('deletebook');
Route::get('/edit-book/{id}', [admincontroller::class, 'editbook'])->name('editbook');
Route::put('/update-book/{id}', [admincontroller::class, 'updatebook'])->name('updatebook');
Route::get('/admin/graduate', [AdminController::class, 'graduateBooks'])->name('admin.graduate');
Route::get('/getting-departments/{out_cat}', [AdminController::class, 'gettingDepartments']);

//SIDEBAR-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/sidebar', [admincontroller::class, 'adminsidebar'])->name('admin.sidebar');


//EMPLOYEE BOOK----------------------------------------------------------------------------------------------------------------------------------------
//Route::get('/admin/employee-table', [admincontroller::class, 'employee_table'])->name('admin.employeebook');
//Route::get('/delete-book/{id}', [admincontroller::class, 'deletebook'])->name('deletebook');
//Route::get('/edit-book/{id}', [admincontroller::class, 'editbook'])->name('editbook');
//Route::put('/update-book/{id}', [admincontroller::class, 'updatebook'])->name('updatebook');
//Route::get('/admin/employee', [AdminController::class, 'employeeBooks'])->name('admin.employeebook');


//UNDERGRADUATE-----------------------------------------------------------------------------------------------------------------------------------
//Route::get('/admin/undergraduate-table', [admincontroller::class, 'undergraduate_table'])->name('admin.undergraduate');
//Route::get('/delete-book/{id}', [admincontroller::class, 'deletebook'])->name('deletebook');
//Route::get('/edit-book/{id}', [admincontroller::class, 'editbook'])->name('editbook');
//Route::put('/update-book/{id}', [admincontroller::class, 'updatebook'])->name('updatebook');
//Route::get('/admin/undergraduate', [AdminController::class, 'undergraduateBooks'])->name('admin.undergraduate');


//DEPARTMENT-------------------------------------------------------------------------------------------------------------------------------------------
//Route::get('/admin/setup/department', [admincontroller::class, 'department'])->name('admin.setup.department');
//Route::post('/admin/setup/department', [admincontroller::class, 'storedepartment'])->name('admin.setup.storedepartment');
//Route::get('/admin/setup/department', [admincontroller::class, 'searchDept'])->name('admin.setup.department');
//Route::get('/delete-dept/{id}', [admincontroller::class, 'deletedept'])->name('deletedept');
//Route::get('/edit-dept/{id}', [admincontroller::class, 'editdept'])->name('editdept');
//Route::put('/update-dept/{id}', [admincontroller::class, 'updatedept'])->name('updatedept');

//USER TYPES-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/usertype', [admincontroller::class, 'usertype'])->name('admin.setup.usertype');
Route::post('/admin/setup/usertype', [admincontroller::class, 'storeusertype'])->name('admin.setup.storeusertype');
Route::get('/admin/setup/usertype', [admincontroller::class, 'searchusertype'])->name('admin.setup.usertype');
Route::get('/delete-usertype/{id}', [admincontroller::class, 'deleteusertype'])->name('deleteusertype');
Route::get('/edit-usertype/{id}', [admincontroller::class, 'editusertype'])->name('editusertype');
Route::put('/update-usertype/{id}', [admincontroller::class, 'updateusertype'])->name('updateusertype');
  
//USER DEPARTMENT-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/userdepartment', [admincontroller::class, 'userdept'])->name('admin.setup.userdepartment');
Route::post('/admin/setup/userdepartment', [admincontroller::class, 'storeuserdept'])->name('admin.setup.storeuserdept');
Route::get('/admin/setup/userdepartment', [admincontroller::class, 'searchuserdept'])->name('admin.setup.userdepartment');
Route::get('/delete-userdepartment/{id}', [admincontroller::class, 'deleteuserdept'])->name('deleteuserdept');
Route::get('/edit-userdepartment/{id}', [admincontroller::class, 'edituserdept'])->name('edituserdept');
Route::put('/update-userdepartment/{id}', [admincontroller::class, 'updateuserdept'])->name('updateuserdept');

//CAROUSEL-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/carousel', [admincontroller::class, 'carousel'])->name('admin.setup.carousel');
Route::post('/admin/setup/carousel', [admincontroller::class, 'storecarousel'])->name('admin.setup.storecarousel');
Route::get('/admin/setup/carousel', [admincontroller::class, 'showcarousel'])->name('admin.setup.carousel');
Route::get('/delete-carousel/{id}', [admincontroller::class, 'deletecarousel'])->name('deletecarousel');
Route::get('/edit-carousel/{id}', [admincontroller::class, 'editcarousel'])->name('editcarousel');
Route::put('/update-carousel/{id}', [admincontroller::class, 'updatecarousel'])->name('updatecarousel');

//RESEARCH OUTPUT CATEGORY-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/output_category', [admincontroller::class, 'resoutcat'])->name('admin.setup.resoutcat');
Route::post('/admin/setup/output_category', [admincontroller::class, 'storeout_cat'])->name('admin.setup.storeout_cat');
Route::get('/admin/setup/output_category', [admincontroller::class, 'searchout_cat'])->name('admin.setup.resoutcat');
Route::get('/delete-output_category/{id}', [admincontroller::class, 'deleteout_cat'])->name('deleteout_cat');
Route::get('/edit-output_category/{id}', [admincontroller::class, 'editout_cat'])->name('editout_cat');
Route::put('/update-output_category/{id}', [admincontroller::class, 'updateout_cat'])->name('updateout_cat');

//UNDER RESEARCH OUTPUT CATEGORY-------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/setup/under_output_category', [admincontroller::class, 'underresoutcat'])->name('admin.setup.under_out_cat');
Route::post('/admin/setup/under_output_category', [admincontroller::class, 'storeunder_out_cat'])->name('admin.setup.storeunder_out_cat');
Route::get('/admin/setup/under_output_category', [admincontroller::class, 'searchunder_out_cat'])->name('admin.setup.under_out_cat');
Route::get('/delete-under_output_category/{id}', [admincontroller::class, 'deleteunder_out_cat'])->name('deleteunder_out_cat');
Route::get('/edit-under_output_category/{id}', [admincontroller::class, 'editunder_out_cat'])->name('editunder_out_cat');
Route::put('/update-under_output_category/{id}', [admincontroller::class, 'updateunder_out_cat'])->name('updateunder_out_cat');



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

//ACCOUNT---------------------------------------------------------------------------------------------------------------------------------------------------
    //USER
Route::get('/admin/account/useraccount', [AccountController::class, 'useracc'])->name('admin.account.useraccount');
Route::get('/delete-useraccount/{id}', [AccountController::class, 'deleteuseracc'])->name('deleteuseracc');
Route::get('/edit-useraccount/{id}', [AccountController::class, 'edituseracc'])->name('edituseracc');
Route::put('/update-useraccount/{id}', [AccountController::class, 'updateuseracc'])->name('updateuseracc');
Route::get('/get-userdepts/{user_type}', [AccountController::class, 'getUserDept']);

    //ADMIN
Route::get('/admin/account/adminaccount', [AccountController::class, 'adminacc'])->name('admin.account.adminaccount');
Route::get('/admin/account/adminaccount', [AccountController::class, 'searchAdminAccount'])->name('admin.account.adminaccount');
Route::get('/delete-adminaccount/{id}', [AccountController::class, 'deleteadminacc'])->name('deleteadminacc');
Route::get('/edit-adminaccount/{id}', [AccountController::class, 'editadminacc'])->name('editadminacc');
Route::put('/update-adminaccount/{id}', [AccountController::class, 'updateadminacc'])->name('updateadminacc');
    
    //GUEST   
Route::get('/admin/account/guestlog', [AccountController::class, 'guestlog'])->name('admin.account.guestlog');
Route::get('/delete-guestlog/{id}', [AccountController::class, 'deleteguestlog'])->name('deleteguestlog');

});

//=================================================================================================================================================

//LOGIN-VIEW-----------------------------------------------------------------------------------------------------------------------
// LOGIN
Route::get('/pages/userlogin', [UserController::class, 'userloginview'])->name('pages.userlogin');
Route::post('/pages/userlogin', [UserController::class, 'userlogin'])->name('pages.userlogin');
Route::get('/pages/guest-login', [UserController::class, 'showGuestLogin'])->name('pages.guestlogin');
Route::post('/pages/guest-login', [UserController::class, 'processGuestLogin'])->name('guest.login.submit');

// USER REGISTRATION
Route::get('/pages/registeruser', [UserController::class, 'registeruser'])->name('pages.registeruser');
Route::post('/pages/registeruser', [UserController::class, 'storeuser'])->name('pages.storeuser');
Route::get('/get-depts/{user_type}', [UserController::class, 'getDept']);

//-------------------------------------------------------------------------------------------------------------------------------------------
//PUBLIC
//--------------------------------------------------------------------------------------------------------------------------------------
// HEADER 
Route::get('/pages/usersheader', [UserController::class, 'usersheader'])->name('pages.usersheader');

// LOGOUT USER
Route::post('/pages/logoutuser', [UserController::class, 'logoutuser'])->name('pages.logoutuser');

// DASHBOARD
Route::get('/pages/userdashboard', [UserController::class, 'userdashboard'])->name('pages.userdashboard');

//-------------------------------------------------------------------------------------------------------------------------------------------
//PROTECTED
//--------------------------------------------------------------------------------------------------------------------------------------

// USERSLINK
Route::middleware(['account.auth'])->group(function () {

    // E-BOOK
    Route::get('/pages/ebook', [UserController::class, 'userebook'])->name('pages.ebook');
    Route::get('/get-deptres/{out_cat}', [UserController::class, 'getDeptres']);


    // FAVORITES
    Route::get('/pages/favorites', [UserController::class, 'userfavorites'])->name('pages.favorites');
    Route::post('/toggle-favorite/{ebook}', [UserController::class, 'toggleFavorite'])->name('toggle.favorite');
    Route::post('/pages/favorites', [UserController::class, 'favstore'])->name('favorites.store')->middleware('account.auth');

    //READ
    Route::post('/read/store', [UserController::class, 'viewstore'])->name('read.store');

    // PROFILE
    Route::get('/pages/profile', [UserController::class, 'userprofile'])->name('pages.profile');
    Route::post('/pages/profile', [UserController::class, 'updateprofile'])->name('pages.profile.update');

});




Route::get('/', [AccountController::class, 'index'])->name('index');




