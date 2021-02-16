<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::orderBy('waktu', 'DESC')->get();
        $response = [
            'message' => 'List transaksi berdasarkan waktu',
            'data' => $transaksi
        ];
        
        return response()->json($response, Response::HTTP_OK);
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
            'judul' => ['required'],
            'jumlah' => ['required', 'numeric'],
            'type' => ['required', 'in:pemasukan,pengeluaran']
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            $transaksi = Transaksi::create($request->all());
            $response = [
                'message' => 'Transaksi dibuat',
                'data' => $transaksi
            ];
            
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return respon()->json([
                'message' => "Gagal " . $e->errorInfo
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
        //
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
        $transaksi = Transaksi::findOrFail($id);
        
        $validator = Validator::make($request->all(),[
            'judul' => ['required'],
            'jumlah' => ['required', 'numeric'],
            'type' => ['required', 'in:pemasukan,pengeluaran']
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            $transaksi->update($request->all());
            $response = [
                'message' => 'Transaksi diedit',
                'data' => $transaksi
            ];
            
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return respon()->json([
                'message' => "Gagal " . $e->errorInfo
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
        //
    }
}
