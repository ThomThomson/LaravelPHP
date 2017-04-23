<?php

namespace App\Http\Controllers;

use App\UserModification;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\UsersToAccessLevel;
use App\AccessLevel;
use App\Article;
use App\Page;
use App\ContentArea;
use App\CssTemplate;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'checkAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::all();
        return view('management.viewUsers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $accessLevels = AccessLevel::all();
        $usersToAccessLevels = UsersToAccessLevel::all();
        $userAccessLevels = [false, false, false];
        return view('management.editUser', compact('accessLevels', 'usersToAccessLevels', 'userAccessLevels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //Validate the Request
        $this->validate($request, [
            'userFName' => 'required',
            'userLName' => 'required',
            'userEmail' => 'required|email|unique:users,email',
            'userPassword' => 'required|confirmed'
        ]);
        //Take input from the request
        $fName = $request->input('userFName');
        $lName = $request->input('userLName');
        $email = $request->input('userEmail');
        $password = Hash::make($request->input('userPassword'));
        //Create a new Article with that input
        $newUser = User::create(['fname' => $fName, 'lname' => $lName, 'email' => $email,
            'password' => $password,'createdBy' => Auth::user()->id]);
        if(!empty($request->input('accessLevels'))) {
            foreach($request->input('accessLevels') as $currentCheckBox){
                //add back in only the accesslevels which have been checked on the form.
                UsersToAccessLevel::create(['userID' => $newUser->id,
                    'accesslevelID' => $currentCheckBox
                ]);
            }
        }
        return redirect('/manage/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $user = User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $usersToAccessLevels = UsersToAccessLevel::all();
        $user = User::find($id);
        $createdBy = User::find($user->createdBy);
        $userAccessLevels = [false, false, false];
        foreach ($usersToAccessLevels as $currentUserToAccessLevel){
            if($user->id == $currentUserToAccessLevel->userID and $currentUserToAccessLevel->accesslevelID == "1"){
                $userAccessLevels[0] = true;
            }else if($user->id == $currentUserToAccessLevel->userID and $currentUserToAccessLevel->accesslevelID == "2"){
                $userAccessLevels[1] = true;
            }else if($user->id == $currentUserToAccessLevel->userID and $currentUserToAccessLevel->accesslevelID == "3"){
                $userAccessLevels[2] = true;
            }
        }
        $modificationList = UserModification::with('User')->where('userModified', $id)->orderBy('created_at', 'desc')->get();
        return view('management.editUser', compact('user','userAccessLevels', 'createdBy', 'modificationList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //Validate the Request
        $this->validate($request, [
            'userFName' => 'required',
            'userLName' => 'required',
            'userEmail' => 'required|email|unique:users,email,'.$id
        ]);
        //Delete all access levels for the user
        UsersToAccessLevel::where('userID', $id)->delete();
        if(!empty($request->input('accessLevels'))) {
            foreach($request->input('accessLevels') as $currentCheckBox){
                //add back in only the accesslevels which have been checked on the form.
                UsersToAccessLevel::create(['userID' => $id,
                    'accesslevelID' => $currentCheckBox
                ]);
            }
        }
        //Take input from the request
        $fName = $request->input('userFName');
        $lName = $request->input('userLName');
        $email = $request->input('userEmail');
        //Get the Article that the request will edit
        $currentUser = User::find($id);
        if(!empty($request->input('userPassword'))) {
            $this->validate($request, [
                'userPassword' => 'confirmed'
            ]);
            $password = Hash::make($request->input('userPassword'));
            $currentUser->password = $password;
        }
        //replace all the params inside the Article.
        $currentUser->fName = $fName; $currentUser->lName = $lName;
        $currentUser->email = $email;
        //save that Article
        $currentUser->save();
        //make a new modification record
        UserModification::create(['modifiedBy' => Auth::user()->id, 'userModified' => $id]);
        //and finally redirect back to Index
        return redirect('/manage/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $currentUser = User::find($id);
        $modifications = UserModification::where('userModified', $currentUser->id)->get();
        foreach($modifications as $modification){
            $modification->delete();
        }
        //change all createdBy fields
        $createdBys = Article::where('createdBy', $currentUser->id)->get();
        foreach($createdBys as $createdRef){
            $createdRef->createdBy = null;//Deleted user created this
            $createdRef->save();
        }
        $createdBys = Page::where('createdBy', $currentUser->id)->get();
        foreach($createdBys as $createdRef){
            $createdRef->createdBy = null;//Deleted user created this
            $createdRef->save();
        }
        $createdBys = CssTemplate::where('createdBy', $currentUser->id)->get();
        foreach($createdBys as $createdRef){
            $createdRef->createdBy = null;//Deleted user created this
            $createdRef->save();
        }
        $createdBys = ContentArea::where('createdBy', $currentUser->id)->get();
        foreach($createdBys as $createdRef){
            $createdRef->createdBy = null;//Deleted user created this
            $createdRef->save();
        }
        $createdBys = User::where('createdBy', $currentUser->id)->get();
        foreach($createdBys as $createdRef){
            $createdRef->createdBy = null;//Deleted user created this
            $createdRef->save();
        }
        $userPrivs = UsersToAccessLevel::where('userID', $currentUser->id)->get();
        foreach($userPrivs as $userPriv){
            $userPriv->delete();
        }
        $currentUser->delete();
        return redirect('/manage/users');
    }
}
