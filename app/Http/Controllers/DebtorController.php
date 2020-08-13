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
              ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
              ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
            //   ->where('cardetails.Date_Appcar','=',Null)
              ->orderBy('data_cuses.DateUser', 'ASC')
              ->get();
            
            $type = $request->type;
            return view('Debtor.view', compact('data','type'));
        }
    }

    public function store(Request $request)
    {
        if($request->type == 1){

          if ($request->get('Amountdeptor') != Null) {
            $SetAmountdeptor = str_replace (",","",$request->get('Amountdeptor'));
          }else {
            $SetAmountdeptor = 0;
          }

          $DataCus = new DataCus([
              'Name_Cus' => $request->get('Namedeptor'),
              'Number_Cus' => $request->get('Contractdeptor'),
              'Cash_Cus' => $SetAmountdeptor,
              'Type_Cus' => $request->get('Typecontract'),
              'NameUser' => auth()->user()->name,
              'DateUser' => date('Y-m-d'),
            ]);
          $DataCus->save();

          if($request->get('Typecontract') == 'กู้-บุคคล'){
              $DataSuretys = new DataSuretys([
                  'DataCus_id' => $DataCus->Cus_id,
                  'Name_Surety' => $request->get('Namesurety'),
                  'Address_Surety' => $request->get('Addresssurety'),
                  'NameUser' => auth()->user()->name,
                  'DateUser' => date('Y-m-d'),
                ]);
              $DataSuretys->save();
          }
          elseif($request->get('Typecontract') == 'กู้-ทรัพย์'){
            $DataMortgagers = new DataMortgagers([
                'DataCus_id' => $DataCus->Cus_id,
                'Name_Mortgager' => $request->get('Namemortgager'),
                'Address_Mortgager' => $request->get('Addressmortgager'),
                'NumberDeed_Mortgager' => $request->get('Noland'),
                'NameUser' => auth()->user()->name,
                'DateUser' => date('Y-m-d'),
              ]);
              $DataMortgagers->save();
          }
  
        }
          
        $type = $request->type;
        return redirect()->Route('Debtor',$type)->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($type,$id,Request $request)
    {
      if ($type == 1) {
        $data = DB::table('data_cuses')
              ->where('data_cuses.Cus_id',$id)->first();
        $Gettype = $type;
        return view('Debtor.edit',compact('data','Gettype'));
      }
      elseif ($type == 2) {
        $data = DB::table('data_cuses')
              ->where('data_cuses.Cus_id',$id)->first();
        $Gettype = $type;
        return view('Debtor.editcourt',compact('data','Gettype'));
      }
      elseif ($type == 3) {
        $data = DB::table('data_cuses')
              ->where('data_cuses.Cus_id',$id)->first();
        $Gettype = $type;
        return view('Debtor.editcourtcase',compact('data','Gettype'));
      }
      elseif ($type == 4) {
        $data = DB::table('data_cuses')
              ->where('data_cuses.Cus_id',$id)->first();
        $Gettype = $type;
        return view('Debtor.editasset',compact('data','Gettype'));
      }


    }

    public function destroy(Request $request, $id, $type)
    {
      // dd($id,$type);
      $item1 = DataCus::find($id);
      if($item1->Type_Cus == 'กู้-บุคคล'){
        $item2 = DataSuretys::where('DataCus_id',$id);
        $item2->Delete();
      }elseif($item1->Type_Cus == 'กู้-ทรัพย์'){
        $item3 = DataMortgagers::where('DataCus_id',$id);
        $item3->Delete();
      }

      $item1->Delete();

      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }
}
