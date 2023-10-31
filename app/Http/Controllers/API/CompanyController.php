<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\company\StoreRequest;
use App\Http\Requests\company\UpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Companies;
use App\Notifications\CompanyNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():JsonResponse
    {
        $data = Companies::paginate(10);
        $data = CompanyResource::collection($data)->response()->getData(true);
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
        $company = new Companies();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        if ($request->has("logo")){
            if ($request->logo != 'null'){
                $fileName = basename($request->file('logo')->storePubliclyAs("company", $request->file('logo')->hashName()));
                $company->logo = $fileName;
            }
        }
        $company->save();
        if($company->email){
            $details = [
                'greeting' => 'Welcome '.$company->name,
                'body' => 'This notification from laravel-task.com',
                'thanks' => 'Thank you for using Laravel Task!',
                'actionText' => 'Task View',
                'actionURL' => url('/'),
            ];
            $company->notify(new CompanyNotification($details));
            Notification::send($company, new CompanyNotification($details));
        }
        return response()->json(["status"=>true, "message"=>"Company saved successfully.", "data"=>$company]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(["status"=>true, "message"=>"", "data"=>new CompanyResource(Companies::find($id)) ]);
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
        $company = Companies::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        if ($request->has("logo")){
            if (Storage::exists("company/".$company->logo)){
                Storage::delete("company/".$company->logo);
            }
            if ($request->logo != 'null'){
                $fileName = basename($request->file('logo')->storePubliclyAs("company", $request->file('logo')->hashName()));
                $company->logo = $fileName;
            }
        }
        $company->update();
        return response()->json(["status" => true, "message"=> "Company update successfully.", "data" => []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id):JsonResponse
    {
        $company = Companies::find($id);
        $company->delete();
        return response()->json(["status" =>  true, "message" => "Company delete successfully.", "data"=>[]]);
    }
}
