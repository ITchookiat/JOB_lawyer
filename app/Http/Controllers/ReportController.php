<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataCus;
use App\DataMortgagers;
use App\DataSuretys;
use App\DataUploadFile;

use DB;
use PDF;

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
            $typeCus = 'กู้-บุคคล';
        }elseif($type == 2){
            $data = DB::table('data_cuses')
                ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
                ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
                ->where('data_cuses.Type_Cus','=', 'กู้-ทรัพย์')
                ->orderBy('data_cuses.DateUser', 'ASC')
                ->get();
            $typeCus = 'กู้-ทรัพย์';
        }
        return view('report.view', compact('data','type','typeCus'));
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
    public function show(Request $request,$id)
    {
        $typeCus = '';
        if ($request->has('typeCus')) {
        $typeCus = $request->get('typeCus');
        }
        if($id == 1){ //Export PDF
            $dataReport = DB::table('data_cuses')
                        ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
                        ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
                        // ->where('data_cuses.Type_Cus','=', 'กู้-บุคคล')
                        ->when(!empty($typeCus), function($q) use($typeCus){
                            return $q->where('data_cuses.Type_Cus',$typeCus);
                          })
                        ->orderBy('data_cuses.DateUser', 'ASC')
                        ->get();

            $view = \View::make('report.export' ,compact(['dataReport','typeCus']));
            $html = $view->render();
            $pdf = new PDF();
            $pdf::SetTitle('รายงาน');
            $pdf::AddPage('L', 'A4');
            // $pdf::SetFont('freeserif');
            // $pdf::SetFont('sarabun');
            $pdf::SetFont('thsarabunpsk', '', 16, '', true);
            // $pdf::SetFont('angsanaupc', '', 16, '', true);
            // $pdf::SetMargins(10, 5, 5, 5);
            // $pdf::SetAutoPageBreak(TRUE, 30);
            $pdf::WriteHTML($html,true,false,true,false,'');
            $pdf::Output('Report.pdf');
        }
        elseif($id == 2){ //Export Excel

        }
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
