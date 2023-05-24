<?php

namespace App\Http\Controllers;

use App\Models\program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class programAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = program::orderBy('id', 'asc');
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function($data) {
            return view('program.tombol')->with('data',$data);
        })
        ->make(true);
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
        $validasi = Validator::make($request->all(),[
            'sumber_dana' => 'required',
            'data_program' => 'required',
            'keterangan' => 'required',
        ],[
            'sumber_dana.required'=>'sumber_dana wajib diisi',
            'data_program.required'=>'data_program wajib diisi',
            'keterangan.required'=>'keterangan wajib diisi',
        ]);

        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'sumber_dana'=>$request->sumber_dana,
                'data_program'=>$request->data_program,
                'keterangan'=>$request->keterangan
            ];
            program::create($data);
            return response()->json(['success' => "berhasil menyimpan data"]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = program::where('id', $id)->first();
        return response()->json(['result' => $data]);
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
        $validasi = Validator::make($request->all(),[
            'sumber_dana' => 'required',
            'data_program' => 'required',
            'keterangan' => 'required',
        ],[
            'sumber_dana.required'=>'sumber_dana wajib diisi',
            'data_program.required'=>'data_program wajib diisi',
            'keterangan.required'=>'keterangan wajib diisi',
        ]);

        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'sumber_dana'=>$request->sumber_dana,
                'data_program'=>$request->data_program,
                'keterangan'=>$request->keterangan
            ];
            program::where('id', $id)->update($data);
            return response()->json(['success' => "berhasil melakukan update data"]);
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
        program::where('id', $id)->delete();
    }
}
