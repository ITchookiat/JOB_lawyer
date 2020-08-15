@extends('layouts.master')
@section('title','ข้อมูลสัญญา')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

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
            <form name="form1" method="post" action="{{ action('DebtorController@update',[$type,$data->Cus_id]) }}" enctype="multipart/form-data">
              @csrf
              @method('put')
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
                                  <option value="ประนอมหนี้" {{ ($data->Status_Cus === 'ประนอมหนี้') ? 'selected' : '' }}>ประนอมหนี้</option>
                                  <option value="ปิดบัญชีประนอมหนี้" {{ ($data->Status_Cus === 'ปิดบัญชีประนอมหนี้') ? 'selected' : '' }}>ปิดบัญชีประนอมหนี้</option>
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
                                  <a class="nav-link active" href="{{ action('DebtorController@edit',[1,$data->Cus_id]) }}">ข้อมูลสัญญา</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="#">ชั้นโนติส</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="{{ action('DebtorController@edit',[2,$data->Cus_id]) }}">ชั้นศาล</a>
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
                  <div class="card-body">
                    <script>
                      function comma(val){
                        while (/(\d+)(\d{3})/.test(val.toString())){
                          val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
                        }
                        return val;
                      }

                      function AddComma(){
                        var principle = document.getElementById('principle').value;
                        var Setprinciple = principle.replace(",","");
                        var Service = document.getElementById('Service').value;
                        var SetService = Service.replace(",","");
                        var overdue = document.getElementById('overdue').value;
                        var Setoverdue = overdue.replace(",","");

                        document.form1.principle.value = comma(Setprinciple);
                        document.form1.Service.value = comma(SetService);
                        document.form1.overdue.value = comma(Setoverdue);
                      }
                    </script>

                    <div class="row ">
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
                              <div class="col-md-6">
                                วันที่ลงสัญญา :
                                <input type="date" name="DateContract" class="form-control">
                              </div>
                              <div class="col-md-6">
                                จำนวนเงินต้น :
                                <input type="text" id="principle" name="principle" value="{{ number_format($data->Principle_Cus,0) }}" class="form-control" oninput="AddComma();">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                ค่าบริการ :
                                <input type="text" id="Service" name="Service" value="{{ number_format($data->Service_cus,0) }}" class="form-control" oninput="AddComma();">
                              </div>
                              <div class="col-md-6">
                                ระยะเวลา (ต่อเดือน) :
                                <input type="text" name="Timeperiod" value="{{ $data->Timeperiod_Cus }}" class="form-control" placeholder="Enter ...">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                ยอดค้าง :
                                <input type="text" id="overdue" name="overdue" value="{{ number_format($data->overdue_Cus,0) }}" class="form-control" placeholder="Enter ..." oninput="AddComma();">
                              </div>
                              <div class="col-md-6">
                                รวม :
                                <input type="text" name="Sum" class="form-control" value="{{ number_format($data->Sum_Cus,0) }}" placeholder="Enter ..." disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-tasks">
                              </i>
                              @if($data->Type_Cus == "กู้-บุคคล")
                                กู้-บุคคล
                              @else
                                กู้-ทรัพย์ (จำนอง)
                              @endif
                            </h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            @if($data->Type_Cus == "กู้-บุคคล")
                              <div class="row">
                                <div class="col-md-6">
                                  ชื่อ - สกุล :
                                <input type="text" name="NameBorrower" value="{{ $data->Name_Surety }}" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="col-md-6">
                                  ที่อยู่ :
                                  <textarea name="AddBorrower" class="form-control" style="width:100%" rows="3">{{ $data->Address_Surety }}</textarea>
                                </div>
                              </div>
                            @else
                              <div class="row">
                                <div class="col-md-6">
                                  ชื่อ - สกุล :
                                  <input type="text" name="NameMortgage" value="{{ $data->Name_Mortgager }}" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="col-md-6">
                                  เลขที่โฉนด :
                                  <input type="text" name="NumberDeed" value="{{ $data->NumberDeed_Mortgager }}" class="form-control" placeholder="Enter ...">
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  ที่อยู่ :
                                  <textarea name="AddMortgage" class="form-control" style="width:100%" rows="3">{{ $data->Address_Mortgager }}</textarea>
                                </div>
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title">เอกสารประกอบ</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <div class="file-loading">
                                <input id="file_image" type="file" name="file_image[]" accept="image/*" data-min-file-count="1" multiple>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
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
                                  <textarea style="width:100%" name="Note" class="form-control" rows="3">{{ $data->Note_Cus }}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="card card-primary">
                          <div class="card-header">
                            <div class="card-title">
                              รูปภาพผู้ค้ำ
                            </div>
                            {{-- @if($data->License_car != NULL)
                              @php
                                $Setlisence = $data->License_car;
                              @endphp
                            @endif --}}
                            <div class="card-tools">
                              <a href="#" class="pull-left DeleteImage">
                                <i class="far fa-trash-alt"></i>
                              </a>
                            </div>
                          </div>
                          
                          <div class="card-body">
                            <div class="row">
                              @foreach($dataImage as $key => $images)
                                @if($images->Type_file == "1")
                                  <div class="col-sm-2">
                                    <a href="{{ asset('upload-image/'.$data->Number_Cus.'/'.$images->Name_file) }}" data-toggle="lightbox" data-title="ภาพผู้ค้ำ">
                                      <img src="{{ asset('upload-image/'.$data->Number_Cus.'/'.$images->Name_file) }}" class="img-fluid mb-2" alt="white sample">
                                    </a>
                                  </div>
                                @endif
                              @endforeach
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
      </section>
    </div>
  </section>

  {{-- แสดงกรอบรูป --}}
  <script>
    $(function () {
      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });
    })
  </script>

  {{-- image --}}
  <script type="text/javascript">
    $("#file_image").fileinput({
      uploadUrl:"{{ route('MasterDeptor.store') }}",
      theme:'fa',
      uploadExtraData:function(){
        return{
          _token:"{{csrf_token()}}",
        }
      },
      allowedFileExtensions:['jpg','png','gif'],
      maxFileSize:10240
    })
  </script>

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

  <script type="text/javascript">
    $("#submit").click(function () {
      $("#modal-printinfo").modal('toggle');
      location.reload(true);
    });
  </script>
@endsection
