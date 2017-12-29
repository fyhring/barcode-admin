<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barcode;

class BarcodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barcodes = Barcode::all();
        return view('codes/list', ['entries' => $barcodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codes/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'barcode' => 'required|unique:barcodes|max:12|min:12',
        ]);

        $barcode = new Barcode();
        $barcode->name = $request->input('name');
        $barcode->barcode = $request->input('barcode');
        $barcode->save();

        return redirect(action('BarcodeController@index'))
            ->with('status', 'Successfully created barcode for '. $barcode->name .'.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(action('BarcodeController@edit', ['id' => $id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barcode = Barcode::find($id);
        return view('codes/edit')
            ->with('barcode', $barcode)
            ->with('id', $id);
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
        $validatedData = $request->validate([
            'name' => 'required',
            'barcode' => 'required|max:12|min:12|unique:barcodes,barcode,'. $id,
        ]);

        $barcode = Barcode::find($id);
        $barcode->name = $request->input('name');
        $barcode->barcode = $request->input('barcode');
        $barcode->save();

        return redirect(action('BarcodeController@index'))
            ->with('status', 'Successfully updated barcode for '. $barcode->name .'.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barcode = Barcode::find($id);

        if ($barcode === null) {
            return redirect(action('BarcodeController@index'))->withErrors(['Unknown barcode ID']);
        }

        $barcode->delete();

        return redirect(action('BarcodeController@index'))->with('status', 'Removed barcode '. $barcode->name .'.');
    }
}
