<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\DataCus;
use App\DataMortgagers;
use App\DataSuretys;
use App\DataUploadFile;
use App\ClassCourt;

use DB;
use Storage;
use File;

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
      elseif ($request->type == 2){
            $newfdate = '';
            $newtdate = '';
            $status = '';
            if ($request->has('Fromdate')) {
              $newfdate = $request->get('Fromdate');
            }
            if ($request->has('Todate')) {
              $newtdate = $request->get('Todate');
            }
            if ($request->has('status')) {
              $status = $request->get('status');
            }
            // dump($newfdate,$newtdate,$status);
            $data = DB::table('data_cuses')
            ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
            ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
            ->when(!empty($newfdate)  && !empty($newtdate), function($q) use ($newfdate, $newtdate) {
              return $q->whereBetween('data_cuses.DateUser',[$newfdate,$newtdate]);
            })
            ->when(!empty($status), function($q) use($status){
              return $q->where('data_cuses.Type_Cus',$status);
            })
            ->orderBy('data_cuses.DateUser', 'ASC')
            ->get();
          
          $type = $request->type;
          return view('Debtor.view', compact('data','type','newfdate','newtdate','status'));
      }
    }

    public function store(Request $request)
    {
      if($request->type == 1){
        $DataCus = new DataCus([
            'Name_Cus' => $request->get('Namedeptor'),
            'Number_Cus' => $request->get('Contractdeptor'),
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
            ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
            ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
            ->where('data_cuses.Cus_id',$id)->first();

        $dataImage = DB::table('data_upload_files')
                ->where('DataCus_id',$data->Cus_id)
                ->where('Type_file','=','fileCus')
                ->get();

        return view('Debtor.edit',compact('data','type','dataImage'));
      }
      elseif ($type == 2) {
        $data = DB::table('data_cuses')
              ->where('data_cuses.Cus_id',$id)->first();

        $dataImage = DB::table('data_upload_files')
              ->where('DataCus_id',$data->Cus_id)
              ->where('Type_file','=','fileCourt')
              ->get();

        $Gettype = $type;
        return view('Debtor.editcourt',compact('data','Gettype','dataImage'));
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

    public function show(Request $request, $id)
    {
        if ($request->type == '1') {   //แสดงรูแ และเอกสาร
            $dataFile = DataUploadFile::where('File_id', $id)->first();
            $path = $request->Con;

          return view('Debtor.preview',compact('dataFile','path'));
        }
    }

    public function update(Request $request, $id)
    {
      if ($request->type == 1) {
        if ($request->get('principle') != Null) {
          $Setprinciple = str_replace (",","",$request->get('principle'));
        }else {
          $Setprinciple = 0;
        }
        if ($request->get('Service') != Null) {
          $SetService = str_replace (",","",$request->get('Service'));
        }else {
          $SetService = 0;
        }
        if ($request->get('overdue') != Null) {
          $Setoverdue = str_replace (",","",$request->get('overdue'));
        }else {
          $Setoverdue = 0;
        }

        $DataCus = DataCus::find($id);
          if ($request->get('statusCus') != NULL) {
            $DataCus->Status_Cus = $request->get('statusCus');
            $DataCus->DateStatus_Cus = date('Y-m-d');
          }
          $DataCus->Name_Cus = $request->get('Namedeptor');
          $DataCus->Number_Cus = $request->get('Contractdeptor');
          $DataCus->Address_Cus = $request->get('Addressdeptor');
          $DataCus->DateCon_Cus = $request->get('DateContract');
          $DataCus->Principle_Cus = $Setprinciple;
          $DataCus->Service_cus = $SetService;
          $DataCus->Timeperiod_Cus = $request->get('Timeperiod');
          $DataCus->overdue_Cus = $Setoverdue;
          $DataCus->Sum_Cus = $request->get('Sum');
          $DataCus->Note_Cus = $request->get('Note');
        $DataCus->update();
        
        if ($DataCus->Type_Cus == "กู้-บุคคล") {
          $Suretys = DataSuretys::where('DataCus_id',$id)->first();
            $Suretys->Name_Surety = $request->get('NameBorrower');
            $Suretys->Address_Surety = $request->get('AddBorrower');
          $Suretys->update();
        }
        elseif ($DataCus->Type_Cus == "กู้-ทรัพย์") {
          $Mortgagers = DataMortgagers::where('DataCus_id',$id)->first();
            $Mortgagers->Name_Mortgager = $request->get('NameMortgage');
            $Mortgagers->NumberDeed_Mortgager = $request->get('NumberDeed');
            $Mortgagers->Address_Mortgager = $request->get('AddMortgage');
          $Mortgagers->update();
        }

        if ($request->hasFile('filePDF')) {
          $image_array = $request->file('filePDF');

            $image_size = $image_array->getClientSize();
            $image_lastname = $image_array->getClientOriginalExtension();
            $image_new_name = $image_array->getClientOriginalName();

            $destination_path = public_path().'/upload-image/'.$DataCus->Number_Cus;
            $image_array->move($destination_path,$image_new_name);

            $Uploaddb = new DataUploadFile([
              'DataCus_id' => $DataCus->Cus_id,
              'Type_file' => "fileCus",
              'Name_file' => $image_new_name,
              'Size_file' => $image_size,
              'Date_file' => date('Y-m-d'),
            ]);
            $Uploaddb ->save();
        }
      }
      elseif ($request->type == 2) {
        $DataCourt = new ClassCourt([
          'DataCus_id' => $id,
          'Datefilling' => $request->get('Datefilling'),
          'Branch' => $request->get('Branch'),
          'NumBlack' => $request->get('NumBlack'),
          'NumRed' => $request->get('NumRed'),
          'Principal' => $request->get('Principal'),
          'Sue' => $request->get('Sue'),
          'Notefilling' => $request->get('Notefilling'),
          'DateExamine' => $request->get('DateExamine'),
          'NextExamine' => $request->get('NextExamine'),
          'NoteExamine' => $request->get('NoteExamine'),
          'DateCompulsory' => $request->get('DateCompulsory'),
          'NextCompulsory' => $request->get('NextCompulsory'),
          'DateSentence' => $request->get('DateSentence'),
          'NoteCompulsory' => $request->get('NoteCompulsory'),
          'DateSetofficer' => $request->get('DateSetofficer'),
          'NextSetofficer' => $request->get('NextSetofficer'),
          'NoteSetofficer' => $request->get('NoteSetofficer'),
          'DateWarrant' => $request->get('DateWarrant'),
          'NextWarrant' => $request->get('NextWarrant'),
          'NoteWarrant' => $request->get('NoteWarrant'),
          'Warrant_Flag' => $request->get('radio-receivedflag'),
          'DateCall' => $request->get('DateCall'),
          'UpdateCall' => $request->get('UpdateCall'),
        ]);
        $DataCourt->save();
      }
      return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(Request $request, $id)
    {
      // dd($request->type,$id);
      if ($request->type == 1) {
        $item1 = DataCus::find($id);
        if($item1->Type_Cus == 'กู้-บุคคล'){
          $item2 = DataSuretys::where('DataCus_id',$id);
          $item2->Delete();
        }elseif($item1->Type_Cus == 'กู้-ทรัพย์'){
          $item3 = DataMortgagers::where('DataCus_id',$id);
          $item3->Delete();
        }
        $item1->Delete();

      }elseif ($request->type == 2) {
        $item1 = DataUploadFile::where('File_id', $id)->first();
        $itemPath = public_path().'/upload-image/'.$request->Con.'/'.$item1->Name_file;

        File::delete($itemPath);
        $item1->Delete();
      }

      return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }
}
