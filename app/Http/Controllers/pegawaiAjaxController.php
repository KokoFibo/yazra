<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class pegawaiAjaxController extends Controller
{

    public function index()
    {

        $data = Pegawai::query();
        return DataTables::of($data)
            // ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                return view('pegawai.tombol')->with('data', $data);
            })
            ->make(true);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'nama' => 'required',
            // 'email' => 'required|email',
            'email' => 'required',
        ], [
            'nama.required' => 'Nama Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            // 'email.email' => 'Format Email harus benar',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {

            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];
            Pegawai::create($data);
            return response()->json(['success' => "Data berhasil di simpan lho"]);
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


    public function edit($id)
    {
        $data = Pegawai::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }


    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required',
            // 'email' => 'required|email',
            'email' => 'required',
        ], [
            'nama.required' => 'Nama Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            // 'email.email' => 'Format Email harus benar',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {

            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];
            Pegawai::where('id', $id)->update($data);
            return response()->json(['success' => "Data berhasil di update"]);
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
        Pegawai::where('id', $id)->delete();
    }
}
