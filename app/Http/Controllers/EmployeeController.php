<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $employee = Employee::paginate(10);
        return response()->json([
            'status' => 'success',
            'data' =>$employee
        ]);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'hire_date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->messages()]);
        }

        $employee = Employee::create ([
            'first_name' => $request->first_name,
            'last_name' => $request ->last_name,
            'birth_date' => $request ->birth_date,
            'gender' => $request ->gender,
            'hire_date' => $request ->hire_date,
        ]);

         if($employee){
            return response()->json([
                'message'=>'berhasil menambahkan data employee',
            ]);
        }else{
            return response()->json([
                'message'=>'gagal menambahkan data employee',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response ()->json ([
            'data'=>$employee
         ]);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
      
        $employee->update($request->all());
        return response ()->json ([
            'status' => 'success',
            'message' => 'salary updated',
            'data'=>$employee
         ]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json ([
            'status' => 'success',
            'message' => 'title berhasil dihapus',
        ]);
    }
}
