<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
Use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
Use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['ERROR'=>'USER NOT FOUND.'],401);
        }
        if(!Hash::check($request->password,$user->password)){
            return response()->json(['error'=>'LOGIN FAILED'],401);
        }
        else{
            auth()->login($user);
            return response()->json(['message'=>'LOGIN SUCCESSFULL'],200);
        }
        
       

    }
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'kategori' => ['required', 'string'],
            
        ]);
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try{ $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password),
            'kategori' => $request->kategori,
            'premium' => 0,
        ]);
        $user->save();
        $response=[
            'massage'=>'Register Successfull'
        ];
        return response()->json($response,Response::HTTP_CREATED);
    }
       
    catch(QueryException $e){
      
        return response()->json([
            'message'=> 'Register Failed'.$e->errorInfo 
        ]);}
    }
}
