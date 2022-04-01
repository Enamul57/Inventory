<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model\EmployeeSalary;
use App\Models\Model\Employee;
use Illuminate\Support\Facades\DB;
class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $emp = Employee::all();
        return response()->json($emp);
         
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
        $employee = new EmployeeSalary;
        $employee->empid = $request->empid;
        $employee->name = $request->name;
        $employee->date = $request->date;
        $employee->month = $request->month;
        $employee->year =  $request->year;
        $employee->paid =  $request->paid;
        $employee->save();
        return response()->json($employee);
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
        
        $checkId = Employee::find($id);
       
        $empsalary = DB::table('employee_salaries')->where('empid',$id)->get();

        if($empsalary != null ){
            return response()->json($empsalary);
        }else{
            $employee = new EmployeeSalary;
            $employee->empid = $checkId->id;
            $employee->name = $checkId->name;
            $employee->date = date('d');
            $employee->month = date('F');
            $employee->year = date('Y');
            $employee->paid = 'Not Paid';
            $employee->save();
            
            $createdEmpSalary = EmployeeSalary::find($id);
            return response()->json($createdEmpSalary);
        }
       
       
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
        
        $salary = array();
        $salary['name'] = $request->name;
        $salary['date'] = $request->date;
        $salary['month'] = $request->month;
        $salary['year'] = $request->year;
        $salary['paid'] = $request->paid;
        $save = DB::table('employee_salaries')->where('empid',$id)->update($salary);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
