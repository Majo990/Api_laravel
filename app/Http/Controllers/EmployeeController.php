<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  
    public function index()
    {
        //
       $employees = Employee::select('employees.*', 'departments.name as department')
       ->join('departments', 'departments.id','=', 'employees.department_id')
       ->paginate(10);
       return response ()->json($employees);
   
    }

   
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|min:1|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ];
        $validator =\Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false ,
                'errors' => $validator->errors()->all()
            ],400);
        }
 $employee = new Employee($request->input());
 $employee->save();
 return response()->json([
    'status' => true ,
    'message' =>  'Employee created successfully'
],200);
    }
    

   
    public function show(Employee $employee)
    {
         return response()->json(['status' => true , 'data' => $employee]);
    }

 
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|min:1|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ];
        $validator =\Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false ,
                'errors' => $validator->errors()->all()
            ],400);
        }

        $employee->update($request->input());
        return response()->json([
            'status' => true ,
            'message' =>'Employee update sucessfully'
        ],200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()-> json ([
            'status' => true ,
            'message' => 'Employee deleted successfully'
        ],200);
    }

    public function EmployeesByDepartment(){
        
    }
}
