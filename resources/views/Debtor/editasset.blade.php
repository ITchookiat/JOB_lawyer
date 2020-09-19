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
                              <a class="nav-link" href="{{ action('DebtorController@edit',[2,$data->Cus_id]) }}">ชั้นศาล</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active" href="{{ action('DebtorController@edit',[4,$data->Cus_id]) }}">สืบทรัพย์</a>
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
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-md-6">
                                      วันสืบทรัพย์
                                      <input type="date" id="Dateasset" name="Dateasset" class="form-control form-control-sm" value="" readonly/>
                                    </div>
                                    <div class="col-md-6">
                                      วันครบกำหนดสืบ
                                      <input type="date" id="" name="" class="form-control form-control-sm" value="" readonly/>
                                    </div>
                                  </div>
                                  
                                  ผลสืบ :
                                  <select id="sendsequesterasset" name="sendsequesterasset" class="form-control form-control-sm">
                                    <option value="" selected>--- เลือกผล ---</option>
                                    <option value="สืบทรัพย์เจอ" >สืบทรัพย์เจอ</option>
                                    <option value="สืบทรัพย์ไม่เจอ" >สืบทรัพย์ไม่เจอ</option>
                                  </select>
                                  ค่าใช้จ่าย
                                  <input type="text" id="Priceasset" name="Priceasset" class="form-control form-control-sm" value="" placeholder="3,000.00" oninput="Comma();"/>
                                  วันที่สืบทรัพย์ใหม่
                                  <input type="date" id="NewpursueDateasset" name="NewpursueDateasset" class="form-control form-control-sm" value=""/>
                                </div>
                                <div class="col-md-6">
                                  หมายเหตุ
                                  <textarea name="Notepursueasset" class="form-control" rows="7"></textarea>
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
