<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\DataCus;
use App\DataMortgagers;
use App\DataSuretys;
use App\DataUploadFile;
use App\ClassCourt;
use App\ClassAssets;

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
            ->leftjoin('class_courts','data_cuses.Cus_id','=','class_courts.DataCus_id')
            ->leftjoin('class_assets','data_cuses.Cus_id','=','class_assets.DataCus_id')
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
            $countData = count($data);
            
            for ($i=0; $i < $countData; $i++) { 
              if($data[$i]->Type_Cus == 'กู้-บุคคล'){
                $Person[] = $data[$i];
              }elseif($data[$i]->Type_Cus == 'กู้-ทรัพย์'){
                $Property[] = $data[$i];
              }
            }
            $countPerson = count($Person);
            $countProperty = count($Property);
            // dd($Person,$Property);
          
          $type = $request->type;
          return view('Debtor.view', compact('data','type','newfdate','newtdate','status','countPerson','countProperty'));
      }
    }

    public function store(Request $request)
    {
      if($request->type == 1){
        $DataCus = new DataCus([
            'Name_Cus' => $request->get('Namedeptor'),
            'Number_Cus' => $request->get('Contractdeptor'),
            'Branch_Cus' => $request->get('BranchCus'),
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
            ->leftjoin('class_courts','data_cuses.Cus_id','=','class_courts.DataCus_id')
            ->where('data_cuses.Cus_id',$id)->first();

        $dataImage = DB::table('data_upload_files')
              ->where('DataCus_id',$data->Cus_id)
              ->where('Type_file','=','fileCourt')
              ->get();

        $Gettype = $type;
        return view('Debtor.editcourt',compact('data','Gettype','dataImage'));
      }
      elseif ($type == 3) {   //สืบทรัพย์
        $data = DB::table('data_cuses')
            ->leftjoin('class_assets','data_cuses.Cus_id','=','class_assets.DataCus_id')
            ->where('data_cuses.Cus_id',$id)->first();

        $Gettype = $type;
        return view('Debtor.editasset',compact('data','Gettype'));
      }
      elseif ($type == 4) {
        $data = DB::table('data_cuses')
              ->where('data_cuses.Cus_id',$id)->first();
        $Gettype = $type;
        return view('Debtor.editcourtcase',compact('data','Gettype'));
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
          $DataCus->Branch_Cus = $request->get('BranchCus');
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
      elseif ($request->type == 2) {    //ชั้นศาล
        $DataCourt = ClassCourt::where('DataCus_id',$id)->first();

        if ($DataCourt != NULL) {
            $DataCourt->Datefilling = $request->get('Datefilling');
            $DataCourt->Branch = $request->get('Branch');
            $DataCourt->NumBlack = $request->get('NumBlack');
            $DataCourt->NumRed = $request->get('NumRed');
            $DataCourt->Principal = $request->get('Principal');
            $DataCourt->Sue = $request->get('Sue');
            $DataCourt->Notefilling = $request->get('Notefilling');
            $DataCourt->DateExamine = $request->get('DateExamine');
            $DataCourt->NextExamine = $request->get('NextExamine');
            $DataCourt->NoteExamine = $request->get('NoteExamine');
            $DataCourt->DateCompulsory = $request->get('DateCompulsory');
            $DataCourt->NextCompulsory = $request->get('NextCompulsory');
            $DataCourt->DateSentence = $request->get('DateSentence');
            $DataCourt->NoteCompulsory = $request->get('NoteCompulsory');
            $DataCourt->DateSetofficer = $request->get('DateSetofficer');
            $DataCourt->NextSetofficer = $request->get('NextSetofficer');
            $DataCourt->NoteSetofficer = $request->get('NoteSetofficer');
            $DataCourt->DateWarrant = $request->get('DateWarrant');
            $DataCourt->NextWarrant = $request->get('NextWarrant');
            $DataCourt->NoteWarrant = $request->get('NoteWarrant');
            $DataCourt->Warrant_Flag = $request->get('radio-receivedflag');
            $DataCourt->DateCall = $request->get('DateCall');
            $DataCourt->UpdateCall = $request->get('UpdateCall');
          $DataCourt->update();
        }else {
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
      }
      elseif ($request->type == 3) {    //สืบทรัพย์
        $DataAssets = ClassAssets::where('DataCus_id',$id)->first();

        if ($DataAssets != NULL) {
            $DataAssets->DateAssets = $request->get('DateAssets');
            $DataAssets->Determine = $request->get('Determine');
            $DataAssets->Consequence = $request->get('Consequence');
            $DataAssets->Charges = $request->get('Charges');
            $DataAssets->NextDateAssets = $request->get('NextDateAssets');
            $DataAssets->NoteAssets = $request->get('NoteAssets');
          $DataAssets->update();
        }else {
          $DataAssets = new ClassAssets([
            'DataCus_id' => $id,
            'DateAssets' => $request->get('DateAssets'),
            'Determine' => $request->get('Determine'),
            'Consequence' => $request->get('Consequence'),
            'Charges' => $request->get('Charges'),
            'NextDateAssets' => $request->get('NextDateAssets'),
            'NoteAssets' => $request->get('NoteAssets'),
          ]);
          $DataAssets->save();
        }
      }
      elseif ($request->type == 4) {
        # code...
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
