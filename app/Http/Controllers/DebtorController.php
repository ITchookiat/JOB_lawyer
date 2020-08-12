<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataCus;
use App\DataMortgagers;
use App\DataSuretys;
use DB;

class DebtorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 1) {

            $data = DB::table('data_cuses')
              ->leftjoin('data_suretys','data_cuses.DataCus_id','=','data_suretys.DataCus_id')
              ->leftjoin('data_mortgagers','data_cuses.DataCus_id','=','data_mortgagers.DataCus_id')
            //   ->where('cardetails.Date_Appcar','=',Null)
              ->orderBy('data_cuses.DateUser', 'ASC')
              ->get();
            
            $type = $request->type;
            return view('Debtor.view', compact('data','type'));
        }
    }

    public function store(Request $request)
    {
        // dd($request->type);
        $DataCus = new DataCus([
            'Name_Cus' => $request->get('Namedeptor'),
            'Number_Cus' => $request->get('Contractdeptor'),
            'Cash_Cus' => $request->get('Amountdeptor'),
            'Type_Cus' => $request->get('Typecontract'),
            'NameUser' => auth()->user()->name,
            'DateUser' => date('Y-m-d'),
          ]);
        $DataCus->save();

        $DataSuretys = new DataSuretys([
            'DataCus_id' => $DataCus->DataCus_id,
            'Name_Surety' => $request->get('Namesurety'),
            'Address_Surety' => $request->get('Addresssurety'),
            'NameUser' => auth()->user()->name,
            'DateUser' => date('Y-m-d'),
          ]);
        $DataSuretys->save();

        $DataMortgagers = new DataMortgagers([
            'DataCus_id' => $DataCus->DataCus_id,
            'Name_Mortgager' => $request->get('Namemortgager'),
            'Address_Mortgager' => $request->get('Addressmortgager'),
            'NumberDeed_Mortgager' => $request->get('Noland'),
            'NameUser' => auth()->user()->name,
            'DateUser' => date('Y-m-d'),
          ]);
          $DataMortgagers->save();

        $type = $request->type;

        return redirect()->Route('Debtor',$type)->with('success','บันทึกข้อมูลเรียบร้อย');
    }
}
