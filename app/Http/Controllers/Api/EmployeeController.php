<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model\Employee;
use Illuminate\Support\Facades\DB;
use Image;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employee = Employee::all();
        return response()->json($employee);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = $request->validate([
            'name'=> 'required|min:4',
            'email'=>'required|unique:employees',
            'phone'=>'required|unique:employees',
            'address'=>'required',
            'joining_date' =>'required'
        ]);

        $image = $request->photo;// abc/jpg;dfdsfsa
        if($image){
            $index_position = strpos($image,';');
            $substr = substr($image,0,$index_position);
            $ext = explode('/',$substr)[1];
            $uniqueName = hexdec(uniqid()).".".$ext;
            $imgFile = Image::make($image)->resize(300,300);
            $upload_path = 'backend/employee/';
            $imageUrl = $upload_path.$uniqueName;
            $imgFile->save($imageUrl);
    
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->joining_date = $request->joining_date;
            $employee->sallery = $request->sallery;
            $employee->nid = $request->nid;
            $employee->photo = $imageUrl;
            $employee->save();
    
        }else{
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->joining_date = $request->joining_date;
            $employee->sallery = $request->sallery;
            $employee->nid = $request->nid;
            $employee->save();
        }

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
        $employee = Employee::find($id);
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
        //
        $employee= array();
        $employee['name'] = $request->name;
        $employee['email'] = $request->email;
        $employee['phone'] = $request->phone;
        $employee['address'] = $request->address;
        $employee['nid'] = $request->nid;
        $employee['sallery'] = $request->sallery;
        $employee['joining_date'] = $request->joining_date;

        $imgFile = $request->newphoto;
        if($imgFile){
            $index_position = strpos($imgFile,';');
            $substr = substr($imgFile,0,$index_position);
            $ext = explode('/',$substr)[1];
            $uniqueName = hexdec(uniqid()).".".$ext;
            $img = Image::make($imgFile)->resize(300,300);
            $path = 'backend/employee/';
            $imgUrl = $path.$uniqueName;
            $imgSave = $img->save($imgUrl);
                if($imgSave){
                    $employee['photo'] = $imgUrl;
                    $database_photo = DB::table('employees')->where('id',$id)->first();
                   if($database_photo->photo){
                    $old_photo = $database_photo->photo;
                    unlink($old_photo);
                   }
                    
                    $user = DB::table('employees')->where('id',$id)->update($employee);
                }
        }else{
            $old_photo = $request->photo;
            $employee['photo'] = $old_photo;
            $user = DB::table('employees')->where('id',$id)->update($employee);
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
        
        $employee = Employee::where('id',$id)->first();
        if($employee->photo){
            unlink($employee->photo);
            $employee->delete();
        }
        else{
            $employee->delete();
        }
        
      
    }
}
