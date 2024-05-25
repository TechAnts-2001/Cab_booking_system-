<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|unique:users,email',
            'phone_number' => 'required|string|max:30|unique:users,phone_number',
            'zip_code' => 'required|string|max:5',
            'password'=> 'required'
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],401);
        }
        DB::beginTransaction();
        try{
            $request['password'] = bcrypt($request->password);
            User::create($request->all());
            DB::commit();
            return response()->json('User is created',201);
        }catch(Exception $e){
            DB::rollback();
            return response()->json("Some thing went wrong");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
