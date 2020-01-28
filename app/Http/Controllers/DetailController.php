<?php

namespace App\Http\Controllers;

use App\Detail;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Detail::create($request->all());

        return json_encode('sukses');
    }

    public function add(Request $request)
    {
        Detail::create($request->all());

        return redirect('/transaction/'.$request->transaction_id.'/edit/')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        return $detail;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail $detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail $detail)
    {
        Detail::where('id', $detail->id)
            ->update([
                'item' => $request->item,
                'qty' => $request->qty,
                'price' => $request->price,
                'total' => $request->total,
            ]);
        
        return redirect('/transaction/'.$detail->transaction_id.'/edit/')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response 
     */
    public function destroy(Detail $detail)
    {
        Detail::destroy($detail->id);

        return redirect('/transaction/'.$detail->transaction_id.'/edit/')->with('status', 'Data berhasil dihapus!');
    }
}
