<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\employe\StoreRequest;
use App\Http\Requests\employe\UpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employees;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = EmployeeResource::collection(Employees::paginate(10))->response()->getData(true);
        return response()->json(["status"=>true, "message"=>"", "data"=>$data]);
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
    public function store(StoreRequest $request):JsonResponse
    {
        $employee = new Employees();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();
        return response()->json(["status"=>true, "message"=>"Employee saved successfully.", "data"=>$employee]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(["status" => true, "message"=>"", "data"=> new EmployeeResource(Employees::find($id))]);
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
    public function update(UpdateRequest $request, $id)
    {
        $employee = Employees::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->update();
        return response()->json(["status" => true, "message" => "Employee update successfully.", "data" => []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employees::find($id);
        $employee->delete();
        return response()->json(["status" => true, "message" => "Employee delete successfully.", "data" => []]);
    }
}
