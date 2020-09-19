<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataCus;
use App\DataMortgagers;
use App\DataSuretys;
use App\DataUploadFile;

use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        if($type == 1){
            $data = DB::table('data_cuses')
                ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
                ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
                ->where('data_cuses.Type_Cus','=', 'กู้-บุคคล')
                ->orderBy('data_cuses.DateUser', 'ASC')
                ->get();
        }elseif($type == 2){
            $data = DB::table('data_cuses')
                ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
                ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
                ->where('data_cuses.Type_Cus','=', 'กู้-ทรัพย์')
                ->orderBy('data_cuses.DateUser', 'ASC')
                ->get();
        }
        return view('report.view', compact('data','type'));
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
        //
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
        //
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
