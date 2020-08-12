@extends('layouts.master')
@section('title','ข้อมูลรถยนต์มือ 2')
@section('content')

@php
 function DateThai($strDate)
    {
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    //return "$strDay-$strMonthThai-$strYear";
    }
@endphp

@php
  date_default_timezone_set('Asia/Bangkok');
  $Y = date('Y') + 543;
  $m = date('m');
  $d = date('d');
  //$date = date('Y-m-d');
  $time = date('H:i');
  $date = $Y.'-'.$m.'-'.$d;
@endphp

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if(session()->has('success'))
        <script type="text/javascript">
          toastr.success('{{ session()->get('success') }}')
        </script>
      @endif

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h1 class="" style="text-align:center;"><b>รายการเตรียมโนติส</b></h1>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    @if($type == 1 or $type == 6)
                      <form method="get" action="#">
                        <div class="float-right form-inline">
                            <label>จากวันที่ : </label>
                            <input type="date" name="Fromdate" value="" class="form-control" />
                            <label>ถึงวันที่ : </label>
                            <input type="date" name="Todate" value="" class="form-control" />
                            &nbsp;
                            <button type="submit" class="btn bg-warning btn-app">
                              <span class="fas fa-search"></span> Search
                            </button>
                            <a class="btn bg-success btn-app" data-toggle="modal" data-target="#modal-lg" data-backdrop="static">
                              <span class="fas fa-file-excel-o"></span> อัพโหลด
                            </a>
                            <a class="btn bg-primary btn-app" data-toggle="modal" data-target="#modal-add" data-backdrop="static">
                              <span class="fas fa-plus"></span> เพิ่มรายการ
                            </a>
                        </div>
                        <br>                        
                        <br>
                        <br>
                      </form>
                    @endif
                      <hr>
                      <div class="table-responsive">
                        <table id="table1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class="text-center" >ลำดับ</th>
                              <th class="text-center" >เลขที่สัญญา</th>
                              <th class="text-center" >ชื่อ - สกุล</th>
                              <th class="text-center" >เลขที่สมาชิก</th>
                              <th class="text-center" >วันทำสัญญา</th>
                              <th class="text-center" >งวดเเรก</th>
                              <th class="text-center" >วงเงินอนุมัติ</th>
                              <th class="text-center" >สถานะ</th>
                              <th class="text-center" >Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key => $row)
                              <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-center">{{$row->Contract_no}}</td>
                                <td class="text-left">{{$row->Name}}</td>
                                <td class="text-center">{{$row->Member_no}}</td>
                                <td class="text-center">{{DateThai($row->Date_contract)}}</td>
                                <td class="text-center">{{DateThai($row->Date_firstdue)}}</td>
                                <td class="text-center">{{number_format($row->Finance_approve,2)}}</td>
                                <td class="text-center">
                                  @if($row->Status_notis == null)
                                    <a class="btn btn-info btn-sm" href="{{ action('LawyerController@updateNotis') }}?id={{$row->Law_id}}&notis={{'yes'}}">
                                      ส่งโนติส
                                    </a>
                                  @else
                                    <a class="btn btn-success btn-sm">
                                      &nbsp;ส่งแล้ว&nbsp;
                                    </a>
                                  @endif
                                </td>
                                <td class="text-center">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-toggle="dropdown">
                                      <span class="fas fa-print"></span>&nbsp;&nbsp;<i class="right fas fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                      <li><a target="_blank" class="dropdown-item" href="{{ action('LawyerController@ReportPDFIndex') }}?id={{$row->Law_id}}&type={{1}}">โนติสผู้กู้</a></li>
                                      <li class="divider"></li>
                                      <li><a target="_blank" class="dropdown-item" href="{{ action('LawyerController@ReportPDFIndex') }}?id={{$row->Law_id}}&type={{2}}">โนติสผู้ค้ำ</a></li>
                                      <li class="divider"></li>
                                      <li><a target="_blank" class="dropdown-item" href="{{ action('LawyerController@ReportPDFIndex') }}?id={{$row->Law_id}}&type={{3}}">โนติสจำนอง</a></li>
                                      <li class="divider"></li>
                                      <li><a target="_blank" class="dropdown-item" href="{{ action('LawyerController@ReportPDFIndex') }}?id={{$row->Law_id}}&type={{4}}">โนติสผู้กู้จำนอง</a></li>
                                      <li class="divider"></li>
                                      <li><a target="_blank" class="dropdown-item" href="{{ action('LawyerController@ReportPDFIndex') }}?id={{$row->Law_id}}&type={{99}}">โนติสทั้งหมด</a></li>
                                    </ul>
                                  </div>
                                  <a href="#" class="btn btn-warning" title="แก้ไขรายการ">
                                    <i class="fas fa-pencil-alt"></i>
                                  </a>
                                  <form method="post" class="delete_form" action="{{ action('LawyerController@destroy',[$row->Law_id]) }}" style="display:inline;">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="delete-modal btn btn-danger" title="ลบรายการ" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?')">
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
                <!-- /.card-body -->
              </div>

              <a id="button"></a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- pop up เพิ่มไฟล์อัพโหลด -->
  <form enctype="multipart/form-data" action="{{ url('/import_excel/import') }}" method="post">
    {{ csrf_field() }}
    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <div class="col text-center">
                <h4 class="modal-title">อัพโหลดไฟล์</h4>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <br />
            @if(count($errors) > 0)
              <div class="alert alert-danger">
              Upload Validation Error<br><br>
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
              </div>
            @endif

            @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="modal-body">
                <!-- <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-3 col-form-label text-right">หัวข้อ : </label>
                      <div class="col-sm-8">
                        <input type="text" name="opic" class="form-control" placeholder="ป้อนหัวข้อ (ถ้ามี)"/>
                      </div>
                    </div>
                  </div>
                </div> -->
                <p></p>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-right"> เลือกไฟล์ Excel :</label>
                      <div class="col-sm-8">
                      <!-- <input type="file" name="file" required/> -->
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile"> *.xlx , *.xlxs </label>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <br/>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-success text-center">อัพโหลด</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
            <br>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  </form>

  <!-- pop up เพิ่มรายการ -->
  <form action="#" method="post">
      <div class="modal fade" id="modal-add" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body">
                <div class="card card-info">
                  <div class="card-header">
                      <h3 class="card-title">รายละเอียดผู้กู้</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-5 col-form-label text-right">เลขที่สัญญา :</label>
                          <div class="col-sm-7">
                            <input type="text" name="Namebuyer" class="form-control" placeholder="ชื่อลูกค้า"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-4 col-form-label text-right">เลขที่สมาชิก :</label>
                          <div class="col-sm-7">
                            <input type="text" name="Nameagent" class="form-control" placeholder="ป้อนชื่อนายหน้า"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-5 col-form-label text-right">ชื่อ-สกลุ ผู้กู้ :</label>
                          <div class="col-sm-7">
                            <input type="text" name="Namebuyer" class="form-control" placeholder="ชื่อลูกค้า"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-4 col-form-label text-right">ชื่อนายหน้า :</label>
                          <div class="col-sm-7">
                            <input type="text" name="Nameagent" class="form-control" placeholder="ป้อนชื่อนายหน้า"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card card-warning">
                  <div class="card-header">
                      <h3 class="card-title">รายละเอียดผู้ค้ำ</h3>
                  </div>
                    <!-- /.card-header -->
                  <div class="card-body">
                    The body of the card
                  </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-danger">
                  <div class="card-header">
                      <h3 class="card-title">รายละเอียดผู้จำนอง</h3>
                  </div>
                    <!-- /.card-header -->
                  <div class="card-body">
                    The body of the card
                  </div>
                    <!-- /.card-body -->
                </div>

                    <input type="hidden" name="Vatcar" value="7 %"/>
                    <input type="hidden" name="evaluetionPrice" value="0"/>
                    <input type="hidden" name="dutyPrice" value="1,500"/>
                    <input type="hidden" name="marketingPrice" value="1,500"/>
              </div>
              <br>
              <div style="text-align: center;">
                  <button type="submit" class="btn btn-success text-center">บันทึก</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
              </div>
              <br>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
  </form>

  {{-- button-to-top --}}
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
    $(".alert").fadeTo(3000, 500).slideUp(500, function(){
    $(".alert").alert('close');
    });
  </script>

  <script>
    $(function () {
      $('#table1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>

@endsection
