<?php

namespace App\Http\Controllers;

use App\Models\cuti_tahunan;
use App\Models\KuotaCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class CutiTahunanController extends Controller
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
        try {
            $this->validate($request, ['user_id' => 'required|unique:kuota_cuti,user_id',]);
            $now = Carbon::now();
            $result = KuotaCuti::create([
                'user_id' => $request->user_id,
                'kuota_cuti' => $request->kuota_cuti,
                'sisa_cuti' => $request->sisa_cuti,
                'periode' => $now->year,
            ]);
            return redirect(route('setting_time_off.index'))->with('message', 'data has saved!');
        } catch (Exception $error) {
            return  redirect(route('setting_time_off.index'))->with('message', (string)$error->getMessage());
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
    public function edit( $id)
    {
        $now = Carbon::now();
        $cuti_tahunan = cuti_tahunan::where('name', $now->year)->first();
        $data = KuotaCuti::find($id);
        return view('setting_timeoff.cuti_tahunan.edit', ["data" => $data , "cuti_tahunan" => $cuti_tahunan]);
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
        $user = KuotaCuti::find($id);
        $user->update($request->all());
        return redirect(route('setting_time_off.index'));
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
