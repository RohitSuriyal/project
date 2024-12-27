<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::post("/login", function (Request $request) {


    $validator = Validator::make($request->all(), [

        "username" => "required",
        "password" => "required|min:6"


    ]);
    if ($validator->fails()) {
       
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    } else {



        $user = User::where('name', $request->username)->first();

        if ($user) {
           
            if (Auth::attempt(['name' => $request->username, 'password' => $request->password])) {
                return redirect()->route("table");
            } else {



                return redirect()->back()
                    ->withErrors([
                        'password' => 'The provided password is incorrect.',
                    ])
                    ->withInput(); 
            }
        } else {

            return redirect()->back()
                ->withErrors([
                    'username' => 'No user found with that email address.',
                ])
                ->withInput(); 
        }
    }
})->name("login");


Route::middleware(['login'])->group(function () {
    Route::get("/table", function (Request $request) {

        $data = DB::table("userdata")->get();
    
    
    
        return view('table', compact('data'));
    })->name("table");
    Route::post("/formdatasubmit", function (Request $request) {
        $validated = $request->validate([
            'title' => ['required', 'regex:/^[A-Za-z\s]+$/'], 
            'description' => 'required|string', 
            'status' => 'required|string', 
            'date' => 'required|date',
        ]);
    
       
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,  
            'date' => $request->date,
        ];
    
       
        $insert = DB::table('userdata')->insert($data);
    
      
        if ($insert) {
            return redirect()->route('table')->with('success', 'Data successfully added.');
        } else {
            return redirect()->route('table')->with('failure', 'Data not added.');
        }
    })->name("formdatasubmit");
    
    Route::get('/updatedata', function (Request $request) {
        $id = $request->id;
        $data = DB::table("userdata")->where("id", $id)->get();
    
        return view("update", compact("data"));
    })->name("updatedata");
    Route::post("/formdatasubmitupdate", function (Request $request) {
        $id = $request->hiddenid;
        $data = [
            "title" => $request->titleupdate,
            "description" => $request->descriptionupdate,
            "status" => $request->statusupdate,
            "date" => $request->dateupdate,
        ];
        $updatedata = DB::table("userdata")->where("id", $id)->update($data);
    
        if ($updatedata > 0) {
            return redirect()->route('table')->with('successupdate', 'Data updated');
        } else {
            return redirect()->route('table')->with('successupdatenochange', 'No data is changes');
        }
    })->name("formdatasubmitupdate");
    
    Route::get("/deletedata", function (Request $request) {
     $id=$request->id;
     $delete=DB::table("userdata")->where("id",$id)->delete();
    
    if($delete>0){
        return redirect()->route('table')->with('delete', 'Record is deleted');
    }
    
    
    
    })->name("deletedata");
    
    Route::post("/filterstatus",function(Request $request){
    
    
        $status=$request->statusfilter;
        $data=DB::table("userdata")->where("status",$status)->get();
        if($data){
    
     return response()->json([
        "data"=>$data,
        "status"=>"success"
     ]);
    
        }
        else{
            return response()->json([
               
                "status"=>"failure"
             ]);
    
        }
    
    })->name("filterstatus");
    
    Route::post("/filterdate",function(Request $request){
    
        $sort=$request->datefilter;
        $data = DB::table('userdata')
        ->orderBy('date', $sort)  
        ->get(); 
        if($data){
    
            return response()->json([
               "data"=>$data,
               "status"=>"success"
            ]);
           
               }
               else{
                   return response()->json([
                      
                       "status"=>"failure"
                    ]);
           
               }
       
      
    
    
    })->name("filterdate");
});

Route::get("/logout",function(){

    Auth::logout();
    return redirect()->route('home');  


})->name("logout");