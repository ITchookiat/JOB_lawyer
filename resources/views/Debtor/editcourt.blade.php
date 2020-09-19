@extends('layouts.master')
@section('title','ชั้นศาล')
@section('content')

  @php
    function DateThai($strDate){
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
      $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strDay $strMonthThai $strYear";
      //return "$strDay-$strMonthThai-$strYear";
    }
  @endphp

  <style>
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label
    {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
        content: '';
        width: 12px;
        height: 12px;
        background: #F87DA9;
        position: absolute;
        top: 4px;
        left: 4px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }
    [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    [type="radio"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
  </style>

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

      <section class="content">
        <div class="row justify-content-center">
          <div class="col-12 table-responsive">
            <form name="form1" method="post" action="{{ route('MasterDeptor.update',[$data->Cus_id]) }}" enctype="multipart/form-data">
              @csrf
              @method('put')
              <input type="hidden" name="type" value="2">

              <div class="card text-sm">
                <div class="card-header">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-inline">
                        <h4>ลูกหนี้งานฟ้อง</h4>
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="card-tools d-inline float-right">
                        <button type="submit" class="delete-modal btn btn-success">
                          <i class="fas fa-save"></i> บันทึก
                        </button>
                        <a class="delete-modal btn btn-danger" href="{{ route('Debtor', 1) }}">
                          <i class="far fa-window-close"></i> ยกเลิก
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                          <h5>{{ $data->Number_Cus }}</h5>
                          <span class="info-box-number">{{ $data->Name_Cus }}</span>
                        </div>
                        <div class="info-box-content">
                          <div class="form-inline float-right">
                            <small class="badge badge-danger" style="font-size: 25px;">
                              <i class="fas fa-sign"></i>&nbsp; สถานะ :
                              <select name="statusCus" class="form-control">
                                <option value="" selected>--------- status ----------</option>
                                <option value="ปิดบัญชี" {{ ($data->Status_Cus === 'ปิดบัญชี') ? 'selected' : '' }}>ปิดบัญชี</option>
                                <option value="ถอนฟ้อง" {{ ($data->Status_Cus === 'ถอนฟ้อง') ? 'selected' : '' }}>ถอนฟ้อง</option>
                                @if($data->Status_Cus != Null)
                                  <option disabled>------------------------------</option>
                                  <option value="{{$data->Status_Cus}}" style="color:red" {{ ($data->Status_Cus === $data->Status_legis) ? 'selected' : '' }}>{{$data->Status_Cus}}</option>
                                @endif
                              </select>
                            </small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>        
                  <div class="card card-warning card-tabs">
                    <div class="card-header p-0 pt-1">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-12">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('DebtorController@edit',[1,$data->Cus_id]) }}">ข้อมูลสัญญา</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link active" href="{{ action('DebtorController@edit',[2,$data->Cus_id]) }}">ชั้นศาล</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('DebtorController@edit',[4,$data->Cus_id]) }}">สืบทรัพย์</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{{ action('DebtorController@edit',[3,$data->Cus_id]) }}">ชั้นบังคับคดี</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>          
                  </div>
                </div>
                <div class="card-body text-sm">
                  <script>
                    function addCommas(nStr){
                        nStr += '';
                        x = nStr.split('.');
                        x1 = x[0];
                        x2 = x.length > 1 ? '.' + x[1] : '';
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                          x1 = x1.replace(rgx, '$1' + ',' + '$2');
                        }
                      return x1 + x2;
                    }
                    function CourtDate(){
                      //---------- วันสืบพยาน
                      var date1 = document.getElementById('DateExamine').value;
                      var fannydate = document.getElementById('NextExamine').value;
                      var DateCompulsory = document.getElementById('DateCompulsory').value;
                      var ordersenddate = document.getElementById('NextCompulsory').value;
    
                      // if (ordersenddate == '') { // แสดงผลลัพธิ์ วันทีดึงจากระบบ
                        console.log(fannydate);
                        if (date1 != '') {
                          var Setdate = new Date(date1);
                          var newdate = new Date(Setdate);
                          if (fannydate != '') {
                            var Setdate = new Date(fannydate);
                            var newdate = new Date(Setdate);
    
                          }
                        }else if (fannydate != '') {
                          var Setdate = new Date(fannydate);
                          var newdate = new Date(Setdate);
                        }
    
                        newdate.setDate(newdate.getDate() + 30);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var yyyy = newdate.getFullYear();
    
                        if (dd < 10) {
                          var Newdd = '0' + dd;
                        }else {
                          var Newdd = dd;
                        }
                        if (mm < 10) {
                          var Newmm = '0' + mm;
                        }else {
                          var Newmm = mm;
                        }
                        var result = yyyy + '-' + Newmm + '-' + Newdd;
                        document.getElementById('DateCompulsory').value = result;
                      // }
                      //---------- end ---------//
    
                      //---------- วันส่งคำบังคับ
                      var date2 = document.getElementById('DateCompulsory').value;
                      var ordersenddate = document.getElementById('NextCompulsory').value;
                        if (date2 != '') {
                          var Setdate = new Date(date2);
                          var newdate = new Date(Setdate);
                          if (ordersenddate != '') {
                            var Setdate = new Date(ordersenddate);
                            var newdate = new Date(Setdate);
                          }
                        }else if (ordersenddate != '') {
                          var Setdate = new Date(ordersenddate);
                          var newdate = new Date(Setdate);
                        }
    
                        newdate.setDate(newdate.getDate() + 45);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var yyyy = newdate.getFullYear();
    
                        if (dd < 10) {
                          var Newdd = '0' + dd;
                        }else {
                          var Newdd = dd;
                        }
                        if (mm < 10) {
                          var Newmm = '0' + mm;
                        }else {
                          var Newmm = mm;
                        }
                        var result = yyyy + '-' + Newmm + '-' + Newdd;
                        document.getElementById('checkdaycourt').value = result;
                      //---------- end ---------//
                    }
                    // ฟังชันคำนวณ วันที่จาก การเลือก checkbox
                    function CourtDate2(){
                      var date = document.getElementById('checkdaycourt').value;
                      var checksenddate = document.getElementById('checksendcourt').value;
    
                      var checkFlag = document.getElementById("1").checked;
                      var messageFlag = document.getElementById("4").checked;
    
                      if (messageFlag == false) {
                        if (checkFlag == false) {
                          var Setdate = new Date(checksenddate);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 15);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('DateCompulsory').value = result;
                        }
                        else {
                          var Setdate = new Date(checksenddate);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var resultcheck = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('DateSetofficer').value = resultcheck;
    
                          var sendoffice = document.getElementById('NextSetofficer').value;
                          var Setdate = new Date(resultcheck);
                          var newdate = new Date(Setdate);
    
                          if (Setdate != '') {
                            var Setdate = new Date(resultcheck);
                            var newdate = new Date(Setdate);
                            if (sendoffice != '') {
                              var Setdate = new Date(sendoffice);
                              var newdate = new Date(Setdate);
                            }
                          }else if (sendoffice != '') {
                            var Setdate = new Date(sendoffice);
                            var newdate = new Date(Setdate);
                          }
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('DateWarrant').value = result;
                        }
                      }
                    }
                    // ฟังชันคำนวณ วันที่จาก ผู้เช่าซื้อกับผู้ค้ำ
                    function CheckMessege(){
                      var buyer = document.getElementById('buyercourt').value;
                      var Setbuyer = buyer.substring(8);
                      var support = document.getElementById('supportcourt').value;
                      var Setsupport = support.substring(8);
    
                      if (Setbuyer != '' && Setsupport != '') {
                        if (Setbuyer == Setsupport) {
                            var Setdate = new Date(buyer);
                            var newdate = new Date(Setdate);
    
                            newdate.setDate(newdate.getDate() + 45);
                            var dd = newdate.getDate();
                            var mm = newdate.getMonth() + 1;
                            var yyyy = newdate.getFullYear();
    
                            if (dd < 10) {
                              var Newdd = '0' + dd;
                            }else {
                              var Newdd = dd;
                            }
                            if (mm < 10) {
                              var Newmm = '0' + mm;
                            }else {
                              var Newmm = mm;
                            }
                            var result = yyyy + '-' + Newmm + '-' + Newdd;
                            document.getElementById('DateSetofficer').value = result;
                        }
                        else if (Setbuyer > Setsupport) {
                          var Setdate = new Date(buyer);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('DateSetofficer').value = result;
    
                        }
                        else if (Setbuyer < Setsupport) {
                          var Setdate = new Date(support);
                          var newdate = new Date(Setdate);
    
                          newdate.setDate(newdate.getDate() + 45);
                          var dd = newdate.getDate();
                          var mm = newdate.getMonth() + 1;
                          var yyyy = newdate.getFullYear();
    
                          if (dd < 10) {
                            var Newdd = '0' + dd;
                          }else {
                            var Newdd = dd;
                          }
                          if (mm < 10) {
                            var Newmm = '0' + mm;
                          }else {
                            var Newmm = mm;
                          }
                          var result = yyyy + '-' + Newmm + '-' + Newdd;
                          document.getElementById('DateSetofficer').value = result;
                        }
    
                        var sendoffice = document.getElementById('NextSetofficer').value;
                        var checkresults = new Date(result);
                        var newdate = new Date(checkresults);
    
                        if (checkresults != '') {
                          var Setdate = new Date(checkresults);
                          var newdate = new Date(Setdate);
                          if (sendoffice != '') {
                            var Setdate = new Date(sendoffice);
                            var newdate = new Date(Setdate);
                          }
                        }else if (sendoffice != '') {
                          var Setdate = new Date(sendoffice);
                          var newdate = new Date(Setdate);
                        }
    
                        newdate.setDate(newdate.getDate() + 45);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var yyyy = newdate.getFullYear();
    
                        if (dd < 10) {
                          var Newdd = '0' + dd;
                        }else {
                          var Newdd = dd;
                        }
                        if (mm < 10) {
                          var Newmm = '0' + mm;
                        }else {
                          var Newmm = mm;
                        }
                        var resultcheck = yyyy + '-' + Newmm + '-' + Newdd;
                        document.getElementById('DateWarrant').value = resultcheck;
                      }
                    }
                    function CalculateCap(){
                        var cap = document.getElementById('Principal').value;
                        var Setcap = cap.replace(",","");
                        var ind = document.getElementById('Sue').value;
                        var Setind = ind.replace(",","");
    
                        var Sumcap = (Setcap * 0.1);
    
                        if(!isNaN(Setcap)){
                            document.form1.Principal.value = addCommas(Setcap);
                            document.form1.pricelawyercourt.value = addCommas(Sumcap.toFixed(2));
                        }
                        if(!isNaN(Setind)){
                            document.form1.Sue.value = addCommas(Setind);
                        }
                    }
                  </script>

                  <h5 class="" align="left"><b>ขั้นตอนชั้นศาล</b></h5>
                  <div class="row">
                    <div class="col-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false"><i class="fas fa-toggle-on"></i> วันฟ้อง(45-60 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-2" data-toggle="pill" href="#tabs-2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-toggle-on"></i> สืบพยาน(30 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-3" data-toggle="pill" href="#tabs-3" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fas fa-toggle-on"></i> ส่งคำบังคับ(45 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-4" data-toggle="pill" href="#tabs-4" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true"><i class="fas fa-toggle-on"></i> ตั้งเจ้าพนักงาน(45 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-5" data-toggle="pill" href="#tabs-5" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true"><i class="fas fa-toggle-on"></i> ตรวจผลหมายตั้ง(30 วัน)</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="row">
                                <div class="col-md-3">
                                  วันที่ฟ้อง
                                  <input type="date" id="Datefilling" name="Datefilling" class="form-control form-control-sm" value="" required/>
                                </div>
                                <div class="col-md-3">
                                  ศาล
                                  <select name="Branch" class="form-control form-control-sm">
                                    <option value="" selected>--- ศาล ---</option>
                                    <option value="ศาลปัตตานี">ศาลปัตตานี</option>
                                    <option value="ศาลยะลา" >ศาลยะลา</option>
                                    <option value="ศาลนราธิวาส" >ศาลนราธิวาส</option>
                                    <option value="ศาลเบตง" >ศาลเบตง</option>
                                    <option value="ศาลนาทวี" >ศาลนาทวี</option>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                  เลขคดีดำ
                                  <input type="text" name="NumBlack" class="form-control form-control-sm" value="" />
                                </div>
                                <div class="col-md-3">
                                  เลขคดีแดง
                                  <input type="text" name="NumRed" class="form-control form-control-sm" value=""  />
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  ทุนทรัพย์
                                  <input type="text" id="Principal" name="Principal" class="form-control form-control-sm" value="" oninput="CalculateCap();"/>
                                </div>
                                <div class="col-md-3">
                                  ค่าฟ้อง
                                  <input type="text" id="Sue" name="Sue" class="form-control form-control-sm" value="" placeholder="5,000.00"  oninput="CalculateCap();"/>
                                </div>
                                <div class="col-md-6">
                                  บันทึกเหตุขัดข้อง
                                  <textarea name="Notefilling" class="form-control" style="width:100%" rows="2"></textarea>
                                </div>
                              </div>
                            </div>      
                            <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่สืบพยาน
                                  <input type="date" id="DateExamine" name="DateExamine" class="form-control form-control-sm" value="" oninput="CourtDate();" />
                                </div>
                                <div class="col-md-6">
                                  วันที่เลือน
                                  <input type="date" id="NextExamine" name="NextExamine" class="form-control form-control-sm" value="" oninput="CourtDate();" />
                                </div>
                              </div>
                              บันทึกเหตุขัดข้อง
                              <textarea name="NoteExamine" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่ส่งคำบังคับ
                                  <input type="date" id="DateCompulsory" name="DateCompulsory" class="form-control form-control-sm" value="" readonly/>
                                </div>
                                <div class="col-md-6">
                                  วันที่ส่งจริง
                                  <input type="date" id="NextCompulsory" name="NextCompulsory" class="form-control form-control-sm" value="" oninput="CourtDate();" />
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  วันคัดคำพิพากษา
                                  <input type="date" id="DateSentence" name="DateSentence" class="form-control form-control-sm" value=""/>
                                </div>
                                <div class="col-md-6">
                                  บันทึกเหตุขัดข้อง
                                  <textarea name="NoteCompulsory" class="form-control" style="width:100%" rows="2"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-4" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันทีตั้งเจ้าพนักงาน
                                  <input type="date" id="DateSetofficer" name="DateSetofficer" class="form-control form-control-sm" value="" readonly/>
                                </div>
                                <div class="col-md-6">
                                  วันที่ส่งจริง
                                  <input type="date" id="NextSetofficer" name="NextSetofficer" class="form-control form-control-sm" value="" oninput="CheckMessege();CourtDate2();"/>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  บันทึกเหตุขัดข้อง
                                  <textarea name="NoteSetofficer" class="form-control" style="width:100%" rows="2"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-5" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-md-6">
                                      วันที่ตรวจผลหมายตั้ง
                                      <input type="date" id="DateWarrant" name="DateWarrant" class="form-control form-control-sm" value="" readonly/>
                                    </div>
                                    <div class="col-md-6">
                                      วันที่ตรวจจริง
                                      <input type="date" id="NextWarrant" name="NextWarrant" class="form-control form-control-sm" value="" oninput="Datesuccess();"/>
                                    </div>
                                    <div class="col-md-12">
                                      บันทึกเหตุขัดข้อง
                                      <textarea name="NoteWarrant" class="form-control" style="width:100%" rows="2"></textarea>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="row" align="center">
                                    <div class="col-md-6">
                                      <input type="radio" id="test3" name="radio-receivedflag" value="ได้รับ" onclick="Functionhidden2()" />
                                      <label for="test3">ได้รับ</label>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="radio" id="test4" name="radio-receivedflag" value="ไม่ได้รับ" onclick="FunctionRadio2()" />
                                      <label for="test4">ไม่ได้รับ</label>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div id="myDIV" style="display:none;">
                                      วันทีโทร
                                      <input type="date" id="DateCall" name="DateCall" class="form-control form-control-sm" value="" />
                                      วันทีไปรับ
                                      <input type="date" id="UpdateCall" name="UpdateCall" class="form-control form-control-sm" value="" oninput="Datesuccess()"/>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="card card-success">
                            <div class="card-header">
                              <h3 class="card-title"><i class="fas fa-marker"></i> เอกสารประกอบชั้นศาล</h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body">
                              เลือกไฟล์ :
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" name="filePDF" class="custom-file-input" id="exampleInputFile" value="">
                                  <label class="custom-file-label" for="exampleInputFile">เลือกไฟล์อัพโหลด</label>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
              <input type="hidden" name="_method" value="PATCH"/>
            </form>

                        <div class="col-md-6">
                          <div class="card card-warning">
                            <div class="card-header">
                              <div class="card-title">
                                เอกสารประกอบชั้นศาล
                              </div>
                              <div class="card-tools">
                                <a href="#" class="pull-left DeleteImage">
                                  <i class="far fa-trash-alt"></i>
                                </a>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                                  <table class="table table-striped table-valign-middle" id="table1">
                                    <thead>
                                      <tr>
                                        <th class="text-center"  style="width: 50px;">No.</th>
                                        <th class="text-center">File Name</th>
                                        <th class="text-center">Date Upload</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($dataImage as $key => $row)
                                        <tr>
                                          <td class="text-center"> {{$key+1}}</td>
                                          <td class="text-left"> 
                                            &nbsp;{{$row->Name_file}}
                                          </td>
                                          <td class="text-left">{{DateThai($row->Date_file)}}</td>
                                          <td class="text-right">
                                            <a target="_blank" href="{{ route('MasterDeptor.show',[$row->File_id]) }}?type={{1}}&Con={{$data->Number_Cus}}" class="btn btn-warning btn-xs" title="ดูไฟล์">
                                              <i class="far fa-eye"></i>
                                            </a>
                                            <form method="post" class="delete_form" action="{{ route('MasterDeptor.destroy',[$row->File_id]) }}?Con={{$data->Number_Cus}}" style="display:inline;">
                                              {{csrf_field()}}
                                              <input type="hidden" name="type" value="2" />
                                              <input type="hidden" name="_method" value="DELETE" />
                                              <button type="submit" data-name="{{$row->Name_file}}" class="delete-modal btn btn-danger btn-xs AlertForm" title="ลบไฟล์">
                                                <i class="far fa-trash-alt"></i>
                                              </button>
                                            </form>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <script>
    function FunctionRadio2() {
      var x = document.getElementById("myDIV");
      if (x.style.display === "none") {
      x.style.display = "block";
      } else {
      x.style.display = "none";
      }
    }

    function Functionhidden2() {
      var x = document.getElementById("myDIV");
      x.style.display = "none";
    }
  </script>
  
  <script>
    function FunctionRadio() {
      var x = document.getElementById("ShowMe");
      if (x.style.display === "none") {
      x.style.display = "block";
      } else {
      x.style.display = "none";
      }
    }

    function Functionhidden() {
      var x = document.getElementById("ShowMe");
      x.style.display = "none";
    }
  </script>
@endsection
