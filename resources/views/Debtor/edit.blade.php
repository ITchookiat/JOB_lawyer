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
                                  <a class="nav-link active" href="{{ action('DebtorController@edit',[1,$data->Cus_id]) }}">ข้อมูลสัญญา</a>
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
                  <div class="card-body text-sm">
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
                                ชื่อ - นามสกุล :
                                <input type="text" name="Namedeptor" value="{{ $data->Name_Cus }}" class="form-control form-control-sm">
                              </div>
                              <div class="col-md-6">
                                เลขที่สัญญา :
                                <input type="text" name="Contractdeptor" value="{{ $data->Number_Cus }}" class="form-control form-control-sm">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                ที่อยู่ :
                                <textarea name="Addressdeptor" class="form-control" style="width:100%" rows="3">{{ $data->Address_Mortgager }}</textarea>
                              </div>
                            </div>
                            <p></p>

                            <div class="row">
                              <div class="col-md-6">
                                วันที่ลงสัญญา :
                                <input type="date" name="DateContract" class="form-control form-control-sm">
                              </div>
                              <div class="col-md-6">
                                จำนวนเงินต้น :
                                <input type="text" id="principle" name="principle" value="{{ number_format($data->Principle_Cus,0) }}" class="form-control form-control-sm" oninput="AddComma();">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                ค่าบริการ :
                                <input type="text" id="Service" name="Service" value="{{ number_format($data->Service_cus,0) }}" class="form-control form-control-sm" oninput="AddComma();">
                              </div>
                              <div class="col-md-6">
                                ระยะเวลา (ต่อเดือน) :
                                <input type="text" name="Timeperiod" value="{{ $data->Timeperiod_Cus }}" class="form-control form-control-sm" placeholder="Enter ...">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                ยอดค้าง :
                                <input type="text" id="overdue" name="overdue" value="{{ number_format($data->overdue_Cus,0) }}" class="form-control form-control-sm" placeholder="Enter ..." oninput="AddComma();">
                              </div>
                              <div class="col-md-6">
                                รวม :
                                <input type="text" name="Sum" class="form-control form-control-sm" value="{{ number_format($data->Sum_Cus,0) }}" placeholder="Enter ..." disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card card-success">
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
                                <input type="text" name="NameBorrower" value="{{ $data->Name_Surety }}" class="form-control form-control-sm" placeholder="Enter ...">
                                </div>
                                <div class="col-md-6">
                                  ที่อยู่ :
                                  <textarea name="AddBorrower" class="form-control form-control-sm" style="width:100%" rows="2">{{ $data->Address_Surety }}</textarea>
                                </div>
                              </div>
                            @else
                              <div class="row">
                                <div class="col-md-6">
                                  ชื่อ - สกุล :
                                  <input type="text" name="NameMortgage" value="{{ $data->Name_Mortgager }}" class="form-control form-control-sm" placeholder="Enter ...">
                                </div>
                                <div class="col-md-6">
                                  เลขที่โฉนด :
                                  <input type="text" name="NumberDeed" value="{{ $data->NumberDeed_Mortgager }}" class="form-control form-control-sm" placeholder="Enter ...">
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  ที่อยู่ :
                                  <textarea name="AddMortgage" class="form-control" style="width:100%" rows="2">{{ $data->Address_Mortgager }}</textarea>
                                </div>
                              </div>
                            @endif
                          </div>
                        </div>
                        
                        <div class="card card-success">
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
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title">เอกสารสัญญา</h3>

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
                        <div class="card card-warning">
                          <div class="card-header">
                            <div class="card-title">
                              เอกสารสัญญา
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
                                    <a href="{{ asset('upload-image/'.$data->Number_Cus.'/'.$images->Name_file) }}" data-toggle="lightbox" data-title="เอกสารสัญญา">
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
