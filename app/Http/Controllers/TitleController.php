<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TitleController extends Controller
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
        $titles = Title::paginate(100);
        return response()->json([
            'status' => 'success',
            'data' => $titles
        ]);
        
        // $title = $request->title;
        // return Title::where("title", "LIKE", "%$title%")->get();
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
        $validator = Validator::make(request()->all(),[

            'emp_no' => 'required|integer|max:11',
            'title' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',

        ]);

        if($validator->fails()){
            return response()->json([$validator->messages()]);
        }

        $title = Title::create([
            'emp_no' => $request->emp_no,
            'title' => $request->title,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);

        if($title){
            return response()->json([
                'message'=>'berhasil menambahkan data title',
            ]);
        }else{
            return response()->json([
                'message'=>'gagal menambahkan data title',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function show(Title $title)
    {
        return response()->json([
            'data' => $title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function edit(Title $title)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Title $title)
    {

        $title->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'title updated',
            'data' => $title
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function destroy(Title $title)
    {
       $title->delete();
       return response()->json([
        'status' => 'success',
        'message' => 'title berhasil dihapus',
    ]);
    } 
}
