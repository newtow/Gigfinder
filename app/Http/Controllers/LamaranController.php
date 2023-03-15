<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Lamaran;
class LamaranController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $lamaran=Lamaran::all();
      
        $response=[
           
            'massage'=>'List lamaran',
            'data'=>$lamaran,       
        ];
  
        return response()->json($response,Response::HTTP_OK);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'title'=>['required'],
            'kategori'=>['required'],
            'file'=>['required'],
            'skill'=>['required'],
            'email'=>['required'],
    ]);
    if($validator->fails()){
        return response()->json($validator->errors(),
        Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    try{
        $lamaran = Lamaran::create($request->all());
        $response=[
            'massage'=>'lamaran created',
            'data'=>$lamaran,
           
        ];
        return response()->json($response,Response::HTTP_CREATED);
    }
    catch(QueryException $e)
    {
        return response()->json([
            'massage'=>'Failed'.$e->errorInfo
        ]);
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
        $lamaran = Lamaran::findOrFail($id);
        $response=[
            'massage'=>'detail of lamaran resourse',
            
            'data'=>$lamaran
        ];
        return response()->json($response,Response::HTTP_OK);
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
        $lamaran= Lamaran::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'title'=>['required'],
            'kategori'=>['required'],
            'file'=>['required'],
            'skill'=>['required'],
            'email'=>['required'],
    ]);
    if($validator->fails()){
        return response()->json($validator->errors(),
        Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    try{
        $lamaran->update($request->all());
        $response=[
            'massage'=>'lamaran updated',
            'data'=>$lamaran
        ];
        return response()->json($response,Response::HTTP_OK);
    }
    catch(QueryException $e)
    {
        return response()->json([
            'massage'=>'Failed'.$e->errorInfo
        ]);
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
        
        $lamaran = Lamaran::findOrFail($id);
       
        try{
            $lamaran ->delete();
            $response=[
                'massage'=>'lamaran deleted',
                
            ];
            return response()->json($response,Response::HTTP_OK);
        }
        catch(QueryException $e)
        {
            return response()->json([
                'massage'=>'Failed'.$e->errorInfo
            ]);
        }
        }
}
