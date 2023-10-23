<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Session;

use DB;
use Illuminate\Hashing\BcryptHasher;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('backoffice.users.index-user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backoffice.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required',
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'default_address_id' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'avatar' => 'required',
            'status' => 'required',
            'is_seen' => 'required|max:1|numeric',
            'phone_verified' => 'required',
            'remember_token' => 'required',
            'auth_id_tiwilo' => 'required',
            'dob' => 'required',
        ]);
        $show = User::create($validatedData);
   
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('backoffice.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role_id' => 'required',
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'default_address_id' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'avatar' => 'required',
            'status' => 'required',
            'is_seen' => 'required',
            'phone_verified' => 'required',
            'remember_token' => 'required',
            'auth_id_tiwilo' => 'required',
            'dob' => 'required',
        ]);
        
        User::where('id', $id)->update($validatedData);

        return redirect('/users')->with('success', 'User Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('success', 'User Data is successfully deleted');
    }

    public function adminlogin(Request $request)
    {        
        try {
            if($request->isMethod('post')){
                    $data = $request->input();
                    $check_auth = Auth::attempt(['username'=>$data['username'],'password'=>$data['password']]);
                if($check_auth){
                    $user = Auth::user();
                    //Session::put('adminSession',$user);                
                    return redirect('/load_stn');
                }else{
                    //return redirect('/')->with('flash_message_error','Invalid username or password.');
                    return back()->with('flash_message_error','Invalid username or password.');
                }
            }
            return view('backoffice.login');
        } catch (\Exception $e) {
            //dd($e);exit;
            //return redirect('')->with('flash_message_error','Invalid username or password.');
            return back()->with('flash_message_error','Invalid username or password.');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        //return redirect('/');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    
    }

    public function createPermission(Request $request)
    {
        $data = $request->all();
        Permission::create(['name' => $data['permissions']]);
        //return redirect('/administrator/Permission')->with('flash_message_success','Permission Addedd Successfully!');
        echo true;
    }

    public function getPermission()
    {
        $users = Permission::select('name','created_at')->get();
        $data = array();
        foreach ($users as $myList)
		{
			$row = array();
            $row['name'] = $myList->name;
            $dt = date_create($myList->created_at);
            $row['created_at'] = date_format($myList->created_at,'Y-m-d');
			$data[] = $row;
        }
		$output = array("data" => $data);
		echo json_encode($output);
    }

    public function createRole(Request $request)
    {
        $data = $request->all();
        Role::create(['name' => $data['role']]);
        //return redirect('/administrator/Role')->with('flash_message_success','Role Addedd Successfully!');
        echo true;
    }

    public function getRole()
    {
        $users = Role::select('name','created_at')->get();
        $data = array();
        foreach ($users as $myList)
		{
			$row = array();
            $row['name'] = $myList->name;
            $dt = date_create($myList->created_at);
            $row['created_at'] = date_format($myList->created_at,'Y-m-d');
		    $row['action'] = '<button class="btn btn-sm btn-primary" title="Permission" onclick="permissionModal('."'".$myList->name."'".')">Permission</button>';
			$data[] = $row;
        }
		$output = array("data" => $data);
		echo json_encode($output);
    }

    public function getPermissionForRole(Request $request)
    {
        $users = Permission::select('name')->get();
        $param = $request->all();
        $data = array();
        foreach ($users as $myList)
		{
			$row = array();
            $row['name'] = $myList->name;
            $role = Role::findByName($param['roles']);
            if($role->hasPermissionTo($myList->name)){
                $row['action'] = '<input type="checkbox" name="my-checkbox" checked class="make-switch" data-size="small" onchange="revoke_permissiong('."'".$myList->name."'".')" data-backdrop="static" data-keyboard="false">';
            }else{
                $row['action'] = '<input type="checkbox" name="my-checkbox" class="make-switch" data-size="small" onchange="add_permissiong('."'".$myList->name."'".')" data-backdrop="static" data-keyboard="false">';
            }
			$data[] = $row;
        }
		$output = array("data" => $data);
		echo json_encode($output);
    }

    public function RoleAddPermission(Request $request)
    {
        $data = $request->all();
        $role = Role::findByName($data['roles']);
        $role->givePermissionTo($data['permissions']);
        $output = array("data" => true);
		echo json_encode($output);
    }

    public function getAllUsers3(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        $dd=1;
        if($val!=''||$start>0){   
            //$dd =  "select * from users where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date("Y-m-d")."' LIMIT $length offset $start";
            $data =  DB::connection('pgsql')->select("select * from users where name ilike '%".$val."%'  LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from users where name ilike '%".$val."%'");
        }else{
            $data =  DB::connection('pgsql')->select("select * from users where cast(created_at as date) >= '".date("Y-m-d")."' LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from users where cast(created_at as date) >= '".date("Y-m-d")."'");
        }

        //$data =  DB::connection('pgsql')->select("select * from users LIMIT $length");
        //$count =  DB::connection('pgsql')->select("select * from users");
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from users");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $arr['name'] =  $value->name;
            $arr['type'] =  $value->type;
            $arr['id'] =  $value->id;
            $data_array[] = $arr;
        }
        
        $page = sizeof($count)/$length;
        $getDecimal =  explode(".",$page);
        $page_count = round(sizeof($count)/$length);
        if(sizeof($getDecimal)==2){            
            if($getDecimal[1]<5){
                $page_count = $getDecimal[0] + 1;
            }
        }
        $datasets = array(["data"=>$data_array,"count"=>$page_count,"showing"=>"Showing ".(($start+10)-9)." to ".($start+10>$count_all_record[0]->count?$count_all_record[0]->count:$start+10)." of ".$count_all_record[0]->count, "patient"=>$data_array]);
        return response()->json($datasets);
    }

    public function getAllUsers(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        $dd=1;
        if($val!=''||$start>0){   
            $data =  DB::connection('pgsql')->select("select * from users where name ilike '%".$val."%' LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from users where name ilike '%".$val."%' ");
        }else{
            $data =  DB::connection('pgsql')->select("select * from users   LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from users  ");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from users where cast(created_at as date) >= '".date("Y-m-d")."'");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $arr['name'] =  $value->name;
            $arr['type'] =  $value->type;
            $arr['id'] =  $value->id;
            $data_array[] = $arr;
        }
        $page = sizeof($count)/$length;
        $getDecimal =  explode(".",$page);
        $page_count = round(sizeof($count)/$length);
        if(sizeof($getDecimal)==2){            
            if($getDecimal[1]<5){
                $page_count = $getDecimal[0] + 1;
            }
        }
        $datasets = array(["data"=>$data_array,"count"=>$page_count,"showing"=>"Showing ".(($start+10)-9)." to ".($start+10>$count_all_record[0]->count?$count_all_record[0]->count:$start+10)." of ".$count_all_record[0]->count, "patient"=>$data_array]);
        return response()->json($datasets);
    }

    public function getAllUsers2()
    {
        $users = User::select('name','email','created_at','id','type','username','is_disabled')->get();
        $data = array();
        foreach ($users as $myList)
		{
			$row = array();
			$row['email'] = $myList->email;
			$row['type'] = $myList->type;
            $row['name'] = $myList->name;
            $row['dctr'] = $myList->dctr;
            $row['prcno'] = $myList->prcno;
            $row['username'] = $myList->username;
            $dt = date_create($myList->created_at);
			$row['created_at'] = date_format($myList->created_at,'Y-m-d');
			$button = '';
            $user = Auth::user();
            
            if($myList->type=="Administrator"){
                //if($user->type=="Administrator"){
                    //$button = $button.'<button class="btn btn-sm btn-success" title="Permissions" onclick="permission_user('."'".$myList->id."'".')">Permissions</button> ';
                    $button = $button.'<button class="btn btn-sm btn-primary" title="Edit" onclick="edit_user('."'".$myList->id."'".')"><i class="fa fa-edit"></i> Edit</button>  ';
                    $button = $button.'<button class="btn btn-sm btn-warning" title="Reset" onclick="reset_password('."'".$myList->id."'".')"><i class="fa fa-repeat"></i> Reset Password</button>  ';
                    $button = $button.($myList->is_disabled==false?'<button class="btn btn-sm btn-danger" title="Reset" onclick="disable_user('."'".$myList->id."'".')"><i class="fa fa-trash"></i> Delete</button>  ':
                    '<button  class="btn btn-sm btn-success" title="Reset" onclick="enable_user('."'".$myList->id."'".')"><i class="fa fa-thumbs-up"></i> Enable</button> ');
                    $row['action'] = $button;
                    $data[] = $row;
                //}
             }else{
                //$button = $button.'<button class="btn btn-sm btn-success" title="Permissions" onclick="permission_user('."'".$myList->id."'".')">Permissions</button> ';
                $button = $button.'<button class="btn btn-sm btn-primary" title="Edit" onclick="edit_user('."'".$myList->id."'".')"><i class="fa fa-edit"></i> Edit</button>  ';
                $button = $button.'<button class="btn btn-sm btn-warning" title="Reset" onclick="reset_password('."'".$myList->id."'".')"><i class="fa fa-repeat"></i> Reset Password</button>  ';
                $button = $button.($myList->is_disabled==false?'<button class="btn btn-sm btn-danger" title="Reset" onclick="disable_user('."'".$myList->id."'".')"><i class="fa fa-trash"></i> Delete</button>  ':
                '<button class="btn btn-sm btn-success" title="Reset" onclick="enable_user('."'".$myList->id."'".')"><i class="fa fa-thumbs-up"></i> Enable</button> ');
                $row['action'] = $button;
			$data[] = $row;
            }
        }
		$output = array("data" => $data);
        //echo json_encode($output);
        //return $output;
        return response()->json($output);
    }

    public function getAllDoctors()
    {
        $users = User::select('name','prcno','id','username')->where('type','Doctors')->get();
        foreach ($users as $myList)
		{
			$row = array();
			$row['prc'] = $myList->prcno;
            $row['name'] = $myList->name;
            $row['username'] = $myList->username;
            $dt = date_create($myList->created_at);
			$row['id'] = $myList->id;
			$data[] = $row;
        }
		$output = array("data" => $data);
		echo json_encode($output);
    }

    public function getPermissionForUser(Request $request)
    {
        $users = Permission::select('name')->get();
        $param = $request->all();
        $data = array();
        foreach ($users as $myList)
		{
			$row = array();
            $row['name'] = $myList->name;
            $user = User::find($param['user']);
            if($user->hasPermissionTo($myList->name)){
                $row['action'] = '<input type="checkbox" name="my-checkbox" checked class="make-switch" data-size="small" onchange="revoke_permission('."'".$myList->name."'".')" data-backdrop="static" data-keyboard="false">';
            }else{
                $row['action'] = '<input type="checkbox" name="my-checkbox" class="make-switch" data-size="small" onchange="add_permission('."'".$myList->name."'".')" data-backdrop="static" data-keyboard="false">';
            }
			$data[] = $row;
        }
		$output = array("data" => $data);
		echo json_encode($output);
    }
    
    //UserAddPermission
    public function UserAddPermission(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['user']);
        $user->givePermissionTo($data['permissions']);
        $output = array("data" => true);
		echo json_encode($output);
    }

    //UserRemovePermission
    public function UserRemovePermission(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['user']);
        $user->revokePermissionTo($data['permissions']);
        $output = array("data" => true);
		echo json_encode($output);
    }


    //UserRemovePermission
    public function RoleRemovePermission(Request $request)
    {
        $data = $request->all();
        $role = Role::findByName($data['role']);
        $role->revokePermissionTo($data['permissions']);
        $output = array("data" => true);
		echo json_encode($output);
    }

    //add or update user accountultra
    public function registerUser(Request $request)
    {
            $data = $request->input();
            $getUser = User::where('id', $data['id'])->first();

            //if(User::where('username', $data['username'])->first()!=null)
            if($getUser)
            {
                User::where(['id'=>$data['id']])->update([
                    'name'=>$data['name'],
                    'username'=>$data['username'],
                    'type'=> $data['type'],
                    'prcno'=> $data['prc'],
                    'ptr'=> $data['ptr'],
                    'signature'=> $data['signatureData'],
                    'username'=> $data['username'],
                    'validity'=> $data['validity'],
                    //'prcno'=>($data['type']=="Secretary"?'':$data['prcno']),
                    //'dctr'=>($data['type']=="Secretary"?$data['doctors']:$data['prcno']),
                    ]
                );
                if(array_key_exists("password",$data)){
                    User::where(['id'=>$data['id']])->update([
                        'password'=>  Hash::make($data['password']),
                        ]
                    );
                }
                /* $output = array("data" => true,"data1" => $data ,"status"=>true,"update"=>"update");
                echo json_encode($output); */
                return 1;
            }
            else{
                $user = new User;
                $status = false;
                    $user->name = $data['name'];
                    $user->username = $data['username'];
                    $user->password = Hash::make($data['password']);
                    $user->type = $data['type'];
                    $user->prcno = $data['prc'];
                    $user->specialization = $data['specialization'];
                    $user->signature = $data['signatureData'];
                    $user->ptr = $data['ptr'];
                    
                    //$user->clinic = $data['clinic'];
                    //$user->prcno = ($data['type']=="Secretary"?'':$data['prcno']);
                    //$user->dctr = ($data['type']=="Secretary"?$data['doctors']:$data['prcno']);
                    $user->save();
                    //$user->syncRoles($data['type']);
                    $status = 0;
               
                
                /* $output = array("data" => true,"user" => $user,"status"=>$status );
                echo json_encode($output); */
                return true;
            }
    }

    public function getUser($id)
    {
        $users = User::select('name','email','created_at','id','type','username','signature','ptr','prcno','specialization','validity')->where('id',$id)->first();
		$output = array("data" => $users);
		//echo json_encode($users);
        return response()->json($users);
    }

    function reset_password($id){
        //DEFAULT PASSWORD
        User::where(['id'=>$id])->update([
            'password'=> Hash::make('P@ssw0rd'),
        ]);
        echo $id;
    }

    function disable_user($id){
        /* User::where(['id'=>$id])->update([
            'is_disabled'=> true,
        ]
        ); */
        User::where(['id'=>$id])->delete();
        echo $id;
    }

    function enable_user($id){
        User::where(['id'=>$id])->update([
            'is_disabled'=> false,
        ]
        );
        echo $id;
    }

    function changepassword (Request $request){
        $user = Auth::user();
        $hasher = app('hash');
        $a = false;
        if($hasher->check($request->cp, $user->password)) {
            $a = 1;
            User::where(['id'=>$user->id])->update([
                'password'=> Hash::make($request->np),
                ]
            );
        }else{
            $a = 0;
        }

        echo $a;
    }

    public function redirect_login($idno)
    {        
        try {
                $check_data = User::where(['unique_id'=>$idno])->first();
                if($check_data){
                    $check_auth = Auth::attempt(['username'=>$check_data->username,'password'=>"P@ssw0rd"]);
                    if($check_auth){
                        $user = Auth::user();
                        //Session::put('adminSession',$user);                
                        return redirect('/load_stn');
                    }else{
                        //dd(app('hash')->make("P@ssw0rd"));
                        return redirect('/')->with('flash_message_error','Invalid username or password.');
                    }
                }else{
                    $communicator_data = DB::connection('communicator')->select("select u.*, d.department_name from users u left join department d on u.department = d.department_id where u.id_number = '$idno'");
                    $new_user = new User;
                    $new_user->name = ucwords($communicator_data[0]->firstname.' '.$communicator_data[0]->lastname);
                    $new_user->email = $idno.'@test.com';
                    $new_user->password = app('hash')->make("P@ssw0rd");
                    $new_user->username = $idno;
                    $new_user->type = ucwords($communicator_data[0]->emp_position);
                    $new_user->unique_id = $idno;
                    //$new_user->station = ucwords($communicator_data[0]->department_name);
                    $new_user->save();

                    $check_auth = Auth::attempt(['username'=>$new_user->username,'password'=>"P@ssw0rd"]);
                    $user = Auth::user();
                    //Session::put('adminSession',$user);                
                    return redirect('/load_stn');
                }  
                
        } catch (\Exception $e) {
            dd($e);exit;
            //return redirect('/')->with('flash_message_error','Invalid username or password.');
        }
    }
}
