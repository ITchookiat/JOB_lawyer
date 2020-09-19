@extends('layouts.master')
@section('title','ชั้นศาล')
@section('content')

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
                <form name="form1" method="post" action="{{ action('DebtorController@update',[$Gettype,$data->Cus_id]) }}" enctype="multipart/form-data">
                  @csrf
                  @method('put')

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
                      var date1 = document.getElementById('examidaycourt').value;
                      var fannydate = document.getElementById('fuzzycourt').value;
                      var orderdaycourt = document.getElementById('orderdaycourt').value;
                      var ordersenddate = document.getElementById('ordersendcourt').value;
    
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
                        document.getElementById('orderdaycourt').value = result;
                      // }
                      //---------- end ---------//
    
                      //---------- วันส่งคำบังคับ
                      var date2 = document.getElementById('orderdaycourt').value;
                      var ordersenddate = document.getElementById('ordersendcourt').value;
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
                          document.getElementById('orderdaycourt').value = result;
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
                          document.getElementById('setofficecourt').value = resultcheck;
    
                          var sendoffice = document.getElementById('sendofficecourt').value;
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
                          document.getElementById('checkresultscourt').value = result;
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
                            document.getElementById('setofficecourt').value = result;
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
                          document.getElementById('setofficecourt').value = result;
    
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
                          document.getElementById('setofficecourt').value = result;
                        }
    
                        var sendoffice = document.getElementById('sendofficecourt').value;
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
                        document.getElementById('checkresultscourt').value = resultcheck;
                      }
                    }
                    function CalculateCap(){
                        var cap = document.getElementById('capitalcourt').value;
                        var Setcap = cap.replace(",","");
                        var ind = document.getElementById('indictmentcourt').value;
                        var Setind = ind.replace(",","");
    
                        var Sumcap = (Setcap * 0.1);
    
                        if(!isNaN(Setcap)){
                            document.form1.capitalcourt.value = addCommas(Setcap);
                            document.form1.pricelawyercourt.value = addCommas(Sumcap.toFixed(2));
                       }
                        if(!isNaN(Setind)){
                            document.form1.indictmentcourt.value = addCommas(Setind);
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
                                  <input type="date" id="fillingdatecourt" name="fillingdatecourt" class="form-control form-control-sm" value="" required/>
                                </div>
                                <div class="col-md-3">
                                  ศาล
                                  <select name="lawcourt" class="form-control form-control-sm">
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
                                  <input type="text" name="bnumbercourt" class="form-control form-control-sm" value="" />
                                </div>
                                <div class="col-md-3">
                                  เลขคดีแดง
                                  <input type="text" name="rnumbercourt" class="form-control form-control-sm" value=""  />
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  ทุนทรัพย์
                                  <input type="text" id="capitalcourt" name="capitalcourt" class="form-control form-control-sm" value="" oninput="CalculateCap();"/>
                                </div>
                                <div class="col-md-3">
                                  ค่าฟ้อง
                                  <input type="text" id="indictmentcourt" name="indictmentcourt" class="form-control form-control-sm" value="" placeholder="5,000.00"  oninput="CalculateCap();"/>
                                </div>
                                <div class="col-md-6">
                                  บันทึกเหตุขัดข้อง
                                  <textarea name="" class="form-control" style="width:100%" rows="2"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่สืบพยาน
                                  <input type="date" id="examidaycourt" name="examidaycourt" class="form-control form-control-sm" value="" oninput="CourtDate();" />
                                </div>
                                <div class="col-md-6">
                                  วันที่เลือน
                                  <input type="date" id="fuzzycourt" name="fuzzycourt" class="form-control form-control-sm" value="" oninput="CourtDate();" />
                                </div>
                              </div>
                              บันทึกเหตุขัดข้อง
                              <textarea name="examinotecourt" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่ส่งคำบังคับ
                                  <input type="date" id="orderdaycourt" name="orderdaycourt" class="form-control form-control-sm" value="" readonly/>
                                </div>
                                <div class="col-md-6">
                                  วันที่ส่งจริง
                                  <input type="date" id="ordersendcourt" name="ordersendcourt" class="form-control form-control-sm" value="" oninput="CourtDate();" />
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  วันคัดคำพิพากษา
                                  <input type="date" id="" name="" class="form-control form-control-sm" value=""/>
                                </div>
                                <div class="col-md-6">
                                  บันทึกเหตุขัดข้อง
                                  <textarea name="" class="form-control" style="width:100%" rows="2"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-4" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันทีตั้งเจ้าพนักงาน
                                  <input type="date" id="setofficecourt" name="setofficecourt" class="form-control form-control-sm" value="" readonly/>
                                </div>
                                <div class="col-md-6">
                                  วันที่ส่งจริง
                                  <input type="date" id="sendofficecourt" name="sendofficecourt" class="form-control form-control-sm" value="" oninput="CheckMessege();CourtDate2();"/>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  บันทึกเหตุขัดข้อง
                                  <textarea name="" class="form-control" style="width:100%" rows="2"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-5" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-md-6">
                                      วันที่ตรวจผลหมายตั้ง
                                      <input type="date" id="checkresultscourt" name="checkresultscourt" class="form-control form-control-sm" value="" readonly/>
                                    </div>
                                    <div class="col-md-6">
                                      วันที่ตรวจจริง
                                      <input type="date" id="sendcheckresultscourt" name="sendcheckresultscourt" class="form-control form-control-sm" value="" oninput="Datesuccess();"/>
                                    </div>
                                    <div class="col-md-12">
                                      บันทึกเหตุขัดข้อง
                                      <textarea name="" class="form-control" style="width:100%" rows="2"></textarea>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="row" align="center">
                                    <div class="col-md-6">
                                      <input type="radio" id="test3" name="radio-receivedflag" value="Y" onclick="Functionhidden2()" />
                                      <label for="test3">ได้รับ</label>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="radio" id="test4" name="radio-receivedflag" value="N" onclick="FunctionRadio2()" />
                                      <label for="test4">ไม่ได้รับ</label>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div id="myDIV" style="display:none;">
                                      วันทีโทร
                                      <input type="date" id="telresultscourt" name="telresultscourt" class="form-control form-control-sm" value="" />
                                      วันทีไปรับ
                                      <input type="date" id="dayresultscourt" name="dayresultscourt" class="form-control form-control-sm" value="" oninput="Datesuccess()"/>
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


                  <input type="hidden" name="_method" value="PATCH"/>
                </form>
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
