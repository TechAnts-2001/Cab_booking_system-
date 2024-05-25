<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data['customer'] = Customer::get();
            return $this->sendResponse('List fetched SuccessFully',$data,200);
        }catch(Exception $e){
            return $this->handleException($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|unique:customers,email',
            'phone_number' => 'required|string|max:30|unique:customers,phone_number',
            'zip_code' => 'required|string|max:5',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return $this->sendError("Please enter valid input data", $validator->errors(), 400);
        }


        DB::beginTransaction();
        try{
            $data['customer'] = Customer::create($validator->validated());
            DB::commit();
            return $this->sendResponse("Customer data is stored",$data,200);
        }catch(Exception $e){
            DB::rollback();
            return $this->handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $data['customer'] = Customer::find($id);
            if(empty($data['customer'])){
                return $this->sendError("Customer not found",["errors" => ['general' => "customer not found"]]);
            }
            return $this->sendResponse('Customer fetched SuccesFully',$data,200);
        }catch(Exception $e){
            return $this->Exception($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $data['customer'] = Customer::find($id);
            if(empty($data['customer'])){
                return $this->sendError("Customer not found",["errors" => ['general' => "customer not found"]]);
            }
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:30',
                'last_name' => 'required|string|max:30',
                'email' => 'required|string|email|unique:customers,email,'.$id,
                'phone_number' => 'required|string|max:30|unique:customers,phone_number,'.$id,
                'zip_code' => 'required|string|max:5',
            ]);
            DB::beginTransaction();
            $update = $validator->validated();
            $data['customer']->update($update);
            DB::commit();
            return $this->sendResponse('Customer updated successFully',$data,201);
        }catch(Exception $e){
            DB::rollback();
            return $this->handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $data['customer'] = Customer::find($id);
            if(empty($data['customer'])){
                return $this->sendError("Customer not found",["errors" => ['general' => "customer not found"]]);
            }
            else{
                DB::beginTransaction();
                $data['customer']->delete();
                DB::commit();
                return $this->sendResponse("Customer deleted succsfully",$data,200);
            }
        }catch(Exception $e){
            DB::rollback();
            return $this->handleException($e);
        }
    }
}
