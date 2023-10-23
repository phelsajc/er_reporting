<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Employee;
use Intervention\Image\ImageManagerStatic as Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo $request->phone;exit;
        $validate = $request->validate([
            'name' => 'required|unique:employee|max:255',
            'email' => 'required',
            'phone' => 'required|unique:employee',
            'name' => 'required|unique:employee|max:255',
            'name' => 'required|unique:employee|max:255',
        ]);
        $image_url = null;
        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/',$sub)[1];

            $name = time().".".$ext;
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $img->save($image_url);

            $emp = new Employee;
            $emp->phone = $request->name;
            $emp->name = $request->name;
            $emp->email = $request->email;
            $emp->salary = $request->salary;
            $emp->address = $request->address;
            $emp->joined_date = $request->joined_date;
            $emp->nid = $request->nid;
            $emp->photo = $image_url;
            //$emp->save();
        }
        $emp = new Employee;
        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->salary = $request->salary;
        $emp->address = $request->address;
        $emp->joined_date = $request->joined_date;
        $emp->nid = $request->nid;
        $emp->photo = $image_url;
        $emp->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where(['id'=>$id])->first();
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $emp = array();
        $emp['name'] = $request->name;
        $emp['email'] = $request->email;
        $emp['phone'] = $request->name;
        $emp['salary'] = $request->salary;
        $emp['address'] = $request->address;
        $emp['nid'] = $request->nid;
        $emp['joined_date'] = $request->joined_date;
        $image = $request->newphoto;

        if($image){
            $position = strpos($image,';');
            $sub = substr($image, 0, $position);
            $ext = explode('/',$sub)[1];

            $name = time().".".$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $emp['photo'] = $image_url;
                $img = Employee::where(['id'=>$id])->first();
                $image_path = $img->photo;
                $done = unlink($image_path);
                $user = Employee::where(['id'=>$id])->update($emp);
            }
        }else{
            $oldphoto = $request->photo;
            $emp['photo'] = $oldphoto;
            $user = Employee::where(['id'=>$id])->update($emp);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Employee::where(['id'=>$id])->first();
        if($emp->photo){
            unlink($emp->photo);
        }
        Employee::where(['id'=>$id])->delete();
        return 1;
    }
}
