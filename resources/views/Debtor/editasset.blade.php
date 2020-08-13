@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
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
            <div class="card">
              <div class="card-header">
                <h4 class="">
                  ลูกหนี้สืบทรัพย์
                </h4>                  
                <div class="card card-warning card-tabs">
                  <div class="card-header p-0 pt-1">
                    <div class="container-fluid">
                      <div class="row mb-2">
                        <div class="col-sm-4">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('DebtorController@edit',[1,$data->Cus_id]) }}">ข้อมูลผู้กู้</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('DebtorController@edit',[2,$data->Cus_id]) }}">ชั้นศาล</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('DebtorController@edit',[3,$data->Cus_id]) }}">ชั้นบังคับคดี</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active" href="{{ action('DebtorController@edit',[4,$data->Cus_id]) }}">สืบทรัพย์</a>
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-6">
                          <!-- <div class="float-right form-inline">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <a class="nav-link active" href="">สืบทรัพย์</a>
                              <a class="nav-link" href="">ประนอมหนี้</a>
                              <a class="nav-link" href="">รูปและแผนที่</a>
                            </ul>
                          </div> -->
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

                  <div class="row">
                    <div class="col-md-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-id-badge fa-2x"></i></span>
          
                        <div class="info-box-content">
                          <div class="form-inline">
                              <div class="col-md-3">
                                <span class="info-box-number"><font style="font-size: 25px;">{{ $data->Number_Cus }}</font></span>
                                <span class="info-box-text"><font style="font-size: 15px;">{{ $data->Name_Cus }}</font></span>
                              </div>

                              <div class="col-md-5">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <small class="badge badge-primary" style="font-size: 25px;">
                                  <i class="fas fa-sign"></i>&nbsp; สถานะ :
                                  @if($data->Status_Cus != Null)
                                    {{$data->Status_Cus}}
                                  @endif
                                </small>
                                <div class="form-inline">
                                  <label>สถานะ : </label>
                                  <select name="Statuslegis" class="form-control" style="width: 170px;">
                                    <option value="" selected>--------- status ----------</option>
                                    <option value="จ่ายจบก่อนฟ้อง" {{ ($data->Status_Cus === 'จ่ายจบก่อนฟ้อง') ? 'selected' : '' }}>จ่ายจบก่อนฟ้อง</option>
                                    <option value="ยึดรถก่อนฟ้อง" {{ ($data->Status_Cus === 'ยึดรถก่อนฟ้อง') ? 'selected' : '' }}>ยึดรถก่อนฟ้อง</option>
                                    <option value="หมดอายุความคดี" {{ ($data->Status_Cus === 'หมดอายุความคดี') ? 'selected' : '' }}>หมดอายุความคดี</option>
                                    @if($data->Status_Cus != Null)
                                      <option disabled>------------------------------</option>
                                      <option value="{{$data->Status_Cus}}" style="color:red" {{ ($data->Status_Cus === $data->Status_legis) ? 'selected' : '' }}>{{$data->Status_Cus}}</option>
                                    @endif
                                  </select>

                                  <input type="date" name="DateStatuslegis" class="form-control" style="width: 170px;" value="">
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="float-right form-inline">
                                  <button type="submit" class="btn btn-app" style="background-color:#189100; color:#FFFFFF;">
                                    <i class="fas fa-save"></i> บันทึก
                                  </button>
                                  <a class="btn btn-app" href="{{ route('Debtor',1) }}" style="background-color:#DB0000; color:#FFFFFF;">
                                    <i class="fas fa-times"></i> ยกเลิก
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <script>
                    function adds(nStr){
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
                    function Comma(){
                      var num11 = document.getElementById('Priceasset').value;
                      var num1 = num11.replace(",","");

                      document.form1.Priceasset.value = adds(num1);
                    }
                  </script>

                  <h5 class="" align="left"><b>ขั้นตอนสืบทรัพย์</b></h5>
                  <div class="row">
                    <div class="col-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false"><i class="fas fa-toggle-on"></i> สถานะทรัพย์</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="row">
                                <div class="col-md-3" align="center">
                                  <input type="radio" id="test1" name="radio_propertied" value="Y" />
                                  <label for="test1">มีทรัพย์</label>
                                </div>
                                <div class="col-md-3" align="center">
                                  <input type="radio" id="test2" name="radio_propertied" value="N" />
                                  <label for="test2">ไม่มีทรัพย์</label>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-inline">
                                  <label>สถานะสืบ : </label>
                                    <select id="statusasset" name="statusasset" class="form-control" style="width: 85%">
                                      <option value="" selected>--- สถานะสืบ ---</option>
                                      <option value="สืบทรัพย์ชั้นศาล">สืบทรัพย์ชั้นศาล</option>
                                      <option value="สืบทรัพย์ชั้นบังคับคดี" >สืบทรัพย์ชั้นบังคับคดี</option>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  วันสืบทรัพย์
                                  <input type="date" id="Dateasset" name="Dateasset" class="form-control" value="" readonly/>
                                  วันสืบทรัพย์ครั้งแรก
                                  <input type="date" id="sequesterasset" name="sequesterasset" class="form-control" value=""/>
                                  ผลสืบ :
                                  <select id="sendsequesterasset" name="sendsequesterasset" class="form-control">
                                    <option value="" selected>--- เลือกผล ---</option>
                                    <option value="สืบทรัพย์เจอ" >สืบทรัพย์เจอ</option>
                                    <option value="สืบทรัพย์ไม่เจอ" >สืบทรัพย์ไม่เจอ</option>
                                    <option value="หมดอายุความคดี" >หมดอายุความคดี</option>
                                    <option value="จบงานสืบทรัพย์" >จบงานสืบทรัพย์</option>
                                  </select>
                                  ค่าใช้จ่าย
                                  <input type="text" id="Priceasset" name="Priceasset" class="form-control" value="" oninput="Comma();"/>
                                  วันที่สืบทรัพย์ใหม่
                                  <input type="date" id="NewpursueDateasset" name="NewpursueDateasset" class="form-control" value=""/>
                                </div>
                                <div class="col-md-6">
                                  หมายเหตุ
                                  <textarea name="Notepursueasset" class="form-control" rows="11"></textarea>
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