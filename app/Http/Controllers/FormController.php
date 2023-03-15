<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Form;
class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $form=Form::all();
      
        $response=[
           
            'massage'=>'List form',
            'data'=>$form,       
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

            'name'=>['required'],
            'age'=>['required'],
            'people'=>['required'],
            'requirement'=>['required'],
            'description'=>['required'],
            'skill'=>['required'],
    ]);
    if($validator->fails()){
        return response()->json($validator->errors(),
        Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    try{
        $form = Form::create($request->all());
        $response=[
            'massage'=>'form created',
            'data'=>$form,
           
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
        $form = Form::findOrFail($id);
        $response=[
            'massage'=>'detail of form resourse',
            
            'data'=>$form
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
        $form= Form::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=>['required'],
            'age'=>['required'],
            'people'=>['required'],
            'requirement'=>['required'],
            'description'=>['required'],
            'skill'=>['required'],
    ]);
    if($validator->fails()){
        return response()->json($validator->errors(),
        Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    try{
        $form->update($request->all());
        $response=[
            'massage'=>'form updated',
            'data'=>$form
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
     * Remove the specified resource form storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $form = Form::findOrFail($id);
       
        try{
            $form ->delete();
            $response=[
                'massage'=>'form deleted',
                
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
