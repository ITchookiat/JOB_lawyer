<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use DB;
use PDF;
use Excel;
use App\Lawyer;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type == 1) {
            $data = DB::table('law_datas')->limit(100)->get();

            $type = $request->type;
            return view('lawyer.view', compact('data','type'));
        }elseif ($request->type == 2) {

            $type = $request->type;
            return view('lawyer.view', compact('type'));
        }
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
    public function updateNotis(Request $request)
    {
        DB::table('law_datas')
          ->where('Law_id', $request->id)
          ->update([
            'Status_notis' => $request->notis
         ]);

        return back()->with('success', 'ส่งโนติสเรียบร้อยแล้ว');
    }
    public function destroy($id)
    {
        $item1 = DB::table('law_datas')->where('Law_id', $id)->delete();

        return back()->with('success', 'ลบรายการเรียบร้อยแล้ว');
    }

    public function ReportPDFIndex(Request $request)
    {
        $dataReport = DB::table('law_datas')
        ->where('Law_id','=',$request->id)
        ->first();

        
        $ReportType = $request->type;
        $view = \View::make('lawyer.export' ,compact(['dataReport','ReportType']));
        $html = $view->render();
        $pdf = new PDF();
        if ($request->type == 1) {
            $pdf::SetTitle('โนติสผู้กู้');
        }
        else if ($request->type == 2) {
            $pdf::SetTitle('โนติสผู้ค้ำ');
        }
        else if ($request->type == 3) {
            $pdf::SetTitle('โนติสจำนอง');
        }
        else if ($request->type == 4) {
            $pdf::SetTitle('โนติสผู้กู้จำนอง');
        }
        else if ($request->type == 99) {
            $pdf::SetTitle('โนติสทั้งหมด');
        }
        $pdf::AddPage('P', 'A4');
        // $pdf::SetFont('freeserif');
        // $pdf::SetFont('sarabun');
        $pdf::SetFont('thsarabunpsk', '', 16, '', true);
        // $pdf::SetFont('angsanaupc', '', 16, '', true);
        // $pdf::SetMargins(10, 5, 5, 5);
        // $pdf::SetAutoPageBreak(TRUE, 30);
        $pdf::WriteHTML($html,true,false,true,false,'');
        $pdf::Output('notis.pdf');
    }

    function import(Request $request)
    {
     $file = $request->file;
     Excel::import(new ExcelImport, $file);
    //  echo "Inserted Successfully";
     return back()->with('success', 'Excel Data Imported successfully.');
    }

}
