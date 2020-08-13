@extends('layouts.master')
@section('title','แผนกวิเคราะห์')
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
    #todo-list{
    width:100%;
    margin:0 auto 50px auto;
    padding:5px;
    background:white;
    position:relative;
    /*box-shadow*/
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
     -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
          box-shadow:0 1px 4px rgba(0, 0, 0, 0.3);
    /*border-radius*/
    -webkit-border-radius:5px;
     -moz-border-radius:5px;
          border-radius:5px;
    }
    #todo-list:before{
    content:"";
    position:absolute;
    z-index:-1;
    /*box-shadow*/
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.4);
     -moz-box-shadow:0 0 20px rgba(0,0,0,0.4);
          box-shadow:0 0 20px rgba(0,0,0,0.4);
    top:50%;
    bottom:0;
    left:10px;
    right:10px;
    /*border-radius*/
    -webkit-border-radius:100px / 10px;
     -moz-border-radius:100px / 10px;
          border-radius:100px / 10px;
    }
    .todo-wrap{
    display:block;
    position:relative;
    padding-left:35px;
    /*box-shadow*/
    -webkit-box-shadow:0 2px 0 -1px #ebebeb;
     -moz-box-shadow:0 2px 0 -1px #ebebeb;
          box-shadow:0 2px 0 -1px #ebebeb;
    }
    .todo-wrap:last-of-type{
    /*box-shadow*/
    -webkit-box-shadow:none;
     -moz-box-shadow:none;
          box-shadow:none;
    }
    input[type="checkbox"]{
    position:absolute;
    height:0;
    width:0;
    opacity:0;
    /* top:-600px; */
    }
    .todo{
    display:inline-block;
    font-weight:200;
    padding:10px 5px;
    height:37px;
    position:relative;
    }
    .todo:before{
    content:'';
    display:block;
    position:absolute;
    top:calc(50% + 2px);
    left:0;
    width:0%;
    height:1px;
    background:#cd4400;
    /*transition*/
    -webkit-transition:.25s ease-in-out;
     -moz-transition:.25s ease-in-out;
       -o-transition:.25s ease-in-out;
          transition:.25s ease-in-out;
    }
    .todo:after{
    content:'';
    display:block;
    position:absolute;
    z-index:0;
    height:18px;
    width:18px;
    top:9px;
    left:-25px;
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #d8d8d8;
     -moz-box-shadow:inset 0 0 0 2px #d8d8d8;
          box-shadow:inset 0 0 0 2px #d8d8d8;
    /*transition*/
    -webkit-transition:.25s ease-in-out;
     -moz-transition:.25s ease-in-out;
       -o-transition:.25s ease-in-out;
          transition:.25s ease-in-out;
    /*border-radius*/
    -webkit-border-radius:4px;
     -moz-border-radius:4px;
          border-radius:4px;
    }
    .todo:hover:after{
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #949494;
     -moz-box-shadow:inset 0 0 0 2px #949494;
          box-shadow:inset 0 0 0 2px #949494;
    }
    .todo .fa-check{
    position:absolute;
    z-index:1;
    left:-31px;
    top:0;
    font-size:1px;
    line-height:36px;
    width:36px;
    height:36px;
    text-align:center;
    color:transparent;
    text-shadow:1px 1px 0 white, -1px -1px 0 white;
    }
    :checked + .todo{
    color:#717171;
    }
    :checked + .todo:before{
    width:100%;
    }
    :checked + .todo:after{
    /*box-shadow*/
    -webkit-box-shadow:inset 0 0 0 2px #0eb0b7;
     -moz-box-shadow:inset 0 0 0 2px #0eb0b7;
          box-shadow:inset 0 0 0 2px #0eb0b7;
    }
    :checked + .todo .fa-check{
    font-size:20px;
    line-height:35px;
    color:#0eb0b7;
    }
    /* Delete Items */

    .delete-item{
    display:block;
    position:absolute;
    height:36px;
    width:36px;
    line-height:36px;
    right:0;
    top:0;
    text-align:center;
    color:#d8d8d8;
    opacity:0;
    }
    .todo-wrap:hover .delete-item{
    opacity:1;
    }
    .delete-item:hover{
    color:#cd4400;
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
                  ลูกหนี้งานฟ้อง
                </h4>
                <div class="card card-warning card-tabs">
                  <div class="card-header p-0 pt-1">
                    <div class="container-fluid">
                      <div class="row mb-2">
                        <div class="col-sm-4">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" href="{{ action('DebtorController@edit',[1,$data->Cus_id]) }}">ข้อมูลผู้กู้</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('DebtorController@edit',[2,$data->Cus_id]) }}">ชั้นศาล</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('DebtorController@edit',[3,$data->Cus_id]) }}">ชั้นบังคับคดี</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ action('DebtorController@edit',[4,$data->Cus_id]) }}">สืบทรัพย์</a>
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-6">
                          <div class="float-right form-inline">
                            <!-- <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <a class="nav-link" href="#">สืบทรัพย์</a>
                              <a class="nav-link" href="#">ประนอมหนี้</a>
                              <a class="nav-link" href="#">รูปและแผนที่</a>
                            </ul> -->
                          </div>
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
                      function comma(val){
                        while (/(\d+)(\d{3})/.test(val.toString())){
                          val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
                        }
                        return val;
                      }

                      function AddComma(){
                        var price = document.getElementById('txtStatuslegis').value;
                        var Setprice = price.replace(",","");

                        document.form1.txtStatuslegis.value = comma(Setprice);
                      }
                    </script>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title"><i class="fas fa-user-tag"></i> ข้อมูลผู้กู้</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                              เลขบัตรประชาชน
                              <div class="form-inline" align="left">
                                <input type="text" name="Idcardlegis" class="form-control" style="width: 100%;" value="" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ป้ายทะเบียน
                              <div class="form-inline" align="left">
                                <input type="text" name="registerlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ยี่ห้อ
                              <div class="form-inline" align="left">
                                <input type="text" name="BrandCarlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              ปีรถ
                              <div class="form-inline" align="left">
                                <input type="text" name="YearCarlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ประเภทรถ
                              <div class="form-inline" align="left">
                                <input type="text" name="Categorylegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              เลขไมล์
                              <div class="form-inline" align="left">
                                <input type="text" name="Milelegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              วันที่ทำสัญญา
                              <div class="form-inline" align="left">
                                <input type="text" name="DateDuelegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ยอดจัด
                              <div class="form-inline" align="left">
                                <input type="text" name="Paylegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ค่าผ่อน
                              <div class="form-inline" align="left">
                                <input type="text" name="Periodlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              จำนวนงวดทั้งหมด
                              <div class="form-inline" align="left">
                                <input type="text" name="Countperiodlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ค้างจากงวดที่
                              <div class="form-inline" align="left">
                                <input type="text" name="Beforeperiodlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ถึงงวดที่
                              <div class="form-inline" align="left">
                                <input type="text" name="Remainperiodlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              ชำระแล้ว
                              <div class="form-inline" align="left">
                                <input type="text" name="Beforemoeylegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ค้าง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค้างงวดจริง
                              <div class="form-inline" align="left">
                                <input type="text" class="form-control" style="width: 40%;" value="" readonly/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="form-control" style="width: 40%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ลูกหนี้คงเหลือ
                              <div class="form-inline" align="left">
                                <input type="text" name="Sumperiodlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="Phonelegis" class="form-control" style="width: 100%;" value="" readonly/>

                          <div class="row">
                            <div class="col-md-4">
                              วันที่หยุด Vat
                              <div class="form-inline" align="left">
                                <input type="text" name="DateVATlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              ชื่อผู้ค้ำ
                              <div class="form-inline" align="left">
                                <input type="text" name="NameGTlegis" class="form-control" style="width: 100%;" value="" readonly/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              เลขบัตรประชาชน
                              <div class="form-inline" align="left">
                                <input type="text" name="IdcardGTlegis" class="form-control" style="width: 100%;" value="" data-inputmask="&quot;mask&quot;:&quot;9-9999-99999-99-9&quot;" data-mask="" readonly/>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title"><i class="fas fa-tasks"></i> เอกสาร</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="" id="todo-list">
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="1" name="Certificatelist" value="on"/>
                                    <label for="1" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือรับรอง
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="2" name="Authorizelist" value="on"/>
                                    <label for="2" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือมอบอำนาจ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="3" name="Authorizecaselist" value="on"/>
                                    <label for="3" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือมอบอำนาจช่วงคดี
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="4" name="Purchaselist" value="on"/>
                                    <label for="4" class="todo">
                                      <i class="fa fa-check"></i>
                                      สัญญาเช่าซื้อ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="5" name="Promiselist" value="on"/>
                                    <label for="5" class="todo">
                                      <i class="fa fa-check"></i>
                                      สัญญาค้ำ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="6" name="Titledeedlist" value="on"/>
                                    <label for="6" class="todo">
                                      <i class="fa fa-check"></i>
                                      โฉนดที่ดิน
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="" id="todo-list">
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="7" name="Terminatebuyerlist" value="on"/>
                                    <label for="7" class="todo">
                                      <i class="fa fa-check"></i>
                                      สัญญาบอกเลิกผู้ซื้อ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="8" name="Terminatesupportlist" value="on"/>
                                    <label for="8" class="todo">
                                      <i class="fa fa-check"></i>
                                      สัญญาบอกเลิกผู้ค้ำ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="9" name="Acceptbuyerandsuplist" value="on"/>
                                    <label for="9" class="todo">
                                      <i class="fa fa-check"></i>
                                      ใบตอบรับผู้ซื้อ - ผู้ค้ำ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="10" name="Twoduelist" value="on"/>
                                    <label for="10" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือ 2 งวด
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="11" name="AcceptTwoduelist" value="on"/>
                                    <label for="11" class="todo">
                                      <i class="fa fa-check"></i>
                                      ใบตอบรับหนังสือ 2 งวด
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="12" name="Confirmlist" value="on"/>
                                    <label for="12" class="todo">
                                      <i class="fa fa-check"></i>
                                      หนังสือยืนยันการบอกเลิก
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                  <span class="todo-wrap">
                                    <input type="checkbox" id="13" name="Acceptlist" value="on"/>
                                    <label for="13" class="todo">
                                      <i class="fa fa-check"></i>
                                      ใบตอบรับ
                                    </label>
                                    <span class="delete-item" title="remove">
                                      <i class="fa fa-times-circle"></i>
                                    </span>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title"><i class="fas fa-marker"></i> หมายเหตุ</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-inline" align="left">
                                <textarea style="width:100%" name="Legisnote" class="form-control" rows="5"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="_method" value="PATCH"/>

                </form>

                <a id="button"></a>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  {{-- back-to-top --}}
  <script>
    var btn = $('#button');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
  </script>

  <script>
    $(function () {
      $('[data-mask]').inputmask()
    })
  </script>

  <script type="text/javascript">
    $("#submit").click(function () {
      $("#modal-printinfo").modal('toggle');
      location.reload(true);
    });
  </script>
@endsection
