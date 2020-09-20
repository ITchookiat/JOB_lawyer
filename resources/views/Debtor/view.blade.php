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

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                <div class="row">
                    <div class="col-8">
                      <div class="form-inline">
                        @if($type == 1)
                          <h5 class="" style="text-align:center;"><b>ติดตามลูกหนี้หลังฟ้อง</b></h5>
                        @elseif($type == 2)
                          <h5 class="" style="text-align:center;"><b>สรุปผลลูกหนี้หลังฟ้อง</b></h5>
                        @endif
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="card-tools d-inline float-right">
                        @if(auth::user()->type == "Admin")
                          <a class="btn bg-primary" data-toggle="modal" data-target="#modal-add" data-backdrop="static">
                            <span class="fas fa-plus-circle"></span> เพิ่ม
                          </a>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body text-sm">
                  @if($type == 1)
                    <form method="get" action="#">
                      <div class="float-right form-inline">
                        <!-- <a class="btn bg-primary btn-app" data-toggle="modal" data-target="#modal-add" data-backdrop="static">
                          <span class="fas fa-plus"></span> เพิ่มรายการ
                        </a> -->
                        <button type="submit" class="btn bg-warning btn-app">
                          <span class="fas fa-search"></span> Search
                        </button>
                      </div>
                      <div class="float-right form-inline">
                        <label>จากวันที่ : </label>
                        <input type="date" name="Fromdate" value="{{ date('Y-m-d') }}" class="form-control" />
                        <label>ถึงวันที่ : </label>
                        <input type="date" name="Todate" value="{{ date('Y-m-d') }}" class="form-control" />
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table id="table1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center" >ลำดับ</th>
                            <th class="text-center" >เลขที่สัญญา</th>
                            <th class="text-center" >ชื่อ - นามสกุล</th>
                            <!-- <th class="text-center" >เลขที่สมาชิก</th>
                            <th class="text-center" >วันทำสัญญา</th>-->
                            <th class="text-center" >จำนวนเงิน</th>
                            {{-- <th class="text-center" >ประเภทสัญญา</th> --}}
                            <th class="text-center" >สถานะ</th> 
                            <th class="text-center" width="70px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $row)
                            <tr>
                              <td class="text-center">{{$key+1}}</td>
                              <td class="text-left">
                                {{$row->Number_Cus}}
                                @if($row->Type_Cus == "กู้-บุคคล")
                                  <span class="badge bg-warning prem">กู้-บุคคล</span>
                                @elseif($row->Type_Cus == "กู้-ทรัพย์")
                                  <span class="badge bg-info prem">กู้-ทรัพย์</span>
                                @endif
                              </td>
                              <td class="text-left">{{$row->Name_Cus}}</td>
                              <td class="text-right">{{number_format($row->Principle_Cus,2)}}</td>
                              <td class="text-center">
                                -
                              </td>
                              <td class="text-right">
                                <a href="{{ action('DebtorController@edit',[$type,$row->Cus_id]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i>
                                </a>
                                <form method="post" class="delete_form" action="{{ route('MasterDeptor.destroy',[$row->Cus_id]) }}?type={{1}}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="เลขที่สัญญา : {{$row->Number_Cus}}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i>
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  
                  @elseif($type == 2)
                    <div class="row">
                      <div class="col-md-6">
                        <div class="card card-primary">
                          <div class="card-header ui-sortable-handle" style="cursor: move;">
                              <h3 class="card-title">
                              <i class="fas fa-chart-pie mr-1"></i>
                              สรุปผลลูกหนี้
                              </h3>
                              <div class="card-tools">
                                  <ul class="nav nav-pills ml-auto">
                                      <li class="nav-item">
                                      <a class="nav-link" href="#tab_1" data-toggle="tab">
                                          Donut
                                      </a>
                                      </li>
                                      <li class="nav-item">
                                      <a class="nav-link" href="#tab_2" data-toggle="tab">
                                          Chart
                                      </a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                          <div class="table-responsive">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div id="donutchart" align="center" style="width: 100%; height: 400px;"></div>
                                    </div>
                                    <div class="tab-pane" id="tab_2">
                                        <div id="columnchart_values" align="center" style="width: 100%; height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <form method="get" action="{{ route('Debtor',2) }}">
                          <div class="row">
                            <div class="col-md-10 col-12">
                              <div class="float-right form-inline">
                                <label>ประเภทสัญญา : </label>
                                <select name="status" class="form-control" id="text">
                                  <option selected value="">---- เลือกประเภท ----</option>
                                  <option value="กู้-บุคคล" {{ ($status == 'กู้-บุคคล') ? 'selected' : '' }}>กู้-บุคคล</otion>
                                  <option value="กู้-ทรัพย์" {{ ($status == 'กู้-ทรัพย์') ? 'selected' : '' }}>กู้-ทรัพย์</otion>
                                </select>
                              </div>
                              <div class="float-right form-inline">
                                <label>จากวันที่ : </label>
                                <input type="date" name="Fromdate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />
                                <label>ถึงวันที่ : </label>
                                <input type="date" name="Todate" value="{{ ($newfdate != '') ?$newfdate: date('Y-m-d') }}" class="form-control" />
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="float-right form-inline">
                                <!-- <a target="_blank" class="btn bg-blue btn-app" data-toggle="modal" data-target="#modal-report">
                                  <i class="fas fa-print"></i> ปริ้นรายงาน
                                </a> -->
                                <button type="submit" class="btn bg-warning btn-app">
                                  <span class="fas fa-search"></span> Search
                                </button>
                              </div>
                            </div>
                          </div>
                        </form>
                        <hr>
                        <div class="table-responsive">
                          <table id="table1" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th class="text-center" >ลำดับ</th>
                                <th class="text-center" >เลขที่สัญญา</th>
                                <th class="text-center" >ชื่อ - สกุล</th>
                                <!-- <th class="text-center" >เลขที่สมาชิก</th>
                                <th class="text-center" >วันทำสัญญา</th>-->
                                <!-- <th class="text-center" >จำนวนเงิน</th> -->
                                <th class="text-center" >ประเภทสัญญา</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($data as $key => $row)
                                <tr>
                                  <td class="text-center">{{$key+1}}</td>
                                  <td class="text-left">{{$row->Number_Cus}}</td>
                                  <td class="text-left">{{$row->Name_Cus}}</td>
                                  <!-- <td class="text-right">{{number_format($row->Cash_Cus,2)}}</td> -->
                                  <td class="text-center">
                                   @if($row->Type_Cus == 'กู้-บุคคล')
                                    <button type="button" class="btn btn-primary btn-xs">
                                      <i class="fas fa-user-check prem"></i> {{$row->Type_Cus}}
                                    </button>
                                   @elseif($row->Type_Cus == 'กู้-ทรัพย์')
                                    <button type="button" class="btn btn-danger btn-xs">
                                        <i class="fas fa-suitcase prem"></i> {{$row->Type_Cus}}
                                      </button>
                                   @endif
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    
                  
                  @endif
                </div>
              </div>

              <a id="button"></a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>
  
  <!-- pop up เพิ่มรายการ -->
  <form name="form2" action="{{ route('MasterDeptor.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="modal fade" id="modal-add" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body">
                <div class="card card-primary">
                  <div class="card-header">
                      <h3 class="card-title">รายละเอียดผู้กู้</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label text-right">ชื่อ-สกุล :</label>
                          <div class="col-sm-8">
                            <input type="text" name="Namedeptor" class="form-control" placeholder="ป้อนชื่อ-สกุลผู้กู้" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                          <label class="col-sm-4 col-form-label text-right">เลขที่สัญญา :</label>
                          <div class="col-sm-8">
                            <input type="text" name="Contractdeptor" class="form-control" placeholder="ป้อนเลขที่สัญญา" maxlength="17"/>
                          </div>
                        </div>
                        <div class="form-group row mb-1">
                          <label class="col-sm-4 col-form-label text-right">ประเภทสัญญา</label>
                          <div class="col-sm-8">
                            <select id="Typecontract" name="Typecontract" class="form-control" required>
                              <option value="" selected>--- เลือกประเภทสัญญา ---</option>
                              <option value="กู้-บุคคล">กู้-บุคคล</option>
                              <option value="กู้-ทรัพย์">กู้-ทรัพย์</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <script>
                  $('#Typecontract').change(function(){
                    var value = document.getElementById('Typecontract').value;
                    if(value == 'กู้-บุคคล'){
                      $('#show1').show();
                      $('#show2').hide();
                    }else if(value == 'กู้-ทรัพย์'){
                      $('#show2').show();
                      $('#show1').hide();
                    }else{
                      $('#show1').hide();
                      $('#show2').hide();
                    }
                  });
                </script>

                <div class="card card-primary" id="show1" style="display:none;">
                  <div class="card-header">
                      <h3 class="card-title">รายละเอียดผู้ค้ำ</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label text-right">ชื่อ-สกุลผู้ค้ำ:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Namesurety" class="form-control" placeholder="ป้อนชื่อ-สกุลผู้ค้ำ"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                          <label class="col-sm-4 col-form-label text-right">ที่อยู่ :</label>
                          <div class="col-sm-8">
                            <!-- <input type="text" name="Addressbuyer" class="form-control" placeholder="ชื่อที่อยู่"/> -->
                            <textarea class="form-control" name="Addresssurety" rows="3" placeholder="ป้อนที่อยู่..."></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card card-primary" id="show2" style="display:none;">
                  <div class="card-header">
                      <h3 class="card-title">รายละเอียดผู้จำนอง</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row mb-1">
                          <label class="col-sm-3 col-form-label text-right">ชื่อ-สกุลผู้จำนอง:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Namemortgager" class="form-control" placeholder="ป้อนชื่อ-สกุลผู้จำนอง"/>
                          </div>
                          <label class="col-sm-3 col-form-label text-right">เลขที่โฉนด:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Noland" class="form-control" placeholder="ป้อนเลขที่โฉนด"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                          <label class="col-sm-4 col-form-label text-right">ที่อยู่ :</label>
                          <div class="col-sm-8">
                            <textarea class="form-control" name="Addressmortgager" rows="3" placeholder="ป้อนที่อยู่..."></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div style="text-align: center;">
                  <button type="submit" class="btn btn-success text-center">บันทึก</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                  <input type="hidden" name="type" value="1"/>
              </div>
              <br>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
  </form>

  <div class="modal fade" id="modal-report" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">รายงานฟ้อง</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label>จากวันที่ : </label>
              <input type="date" name="Fromdate" value="{{ date('Y-m-d') }}" class="form-control" />
            </div>
            <div class="col-md-6">
              <label>ถึงวันที่ : </label>
              <input type="date" name="Todate" value="{{ date('Y-m-d') }}" class="form-control" />
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <label>สถานะ </label>
              <div class="form-inline" style="border: 1px solid #D0D0CB; border-radius: 5px; padding:10px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id="customCheckbox10" type="checkbox" name="Typetransfer[]" value="โอนจัดไฟแนนซ์">
                  <label class="custom-control-label" for="customCheckbox10"></label> ชั้นศาล
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id="customCheckbox11" type="checkbox" name="Typetransfer[]" value="โอนออก">
                  <label class="custom-control-label" for="customCheckbox11"></label> สืบทรัพย์
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id="customCheckbox12" type="checkbox" name="Typetransfer[]" value="จดทะเบียนรถใหม่">
                  <label class="custom-control-label" for="customCheckbox12"></label> ชั้นบังคับคดี
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id="customCheckbox13" type="checkbox" name="Typetransfer[]" value="อื่นๆ">
                  <label class="custom-control-label" for="customCheckbox13"></label> จบงาน
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Print</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

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
    $(function () {
      $('#table1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
      });
    });
  </script>

  <script>
    function blinker() {
    $('.prem').fadeOut(1500);
    $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);
  </script>

@if($type == 2)
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['ประเภทสัญญา', 'จำนวน'],
        ['กู้-บุคคล', {{$countPerson}}],
        ['กู้-ทรัพย์', {{$countProperty}}],
      ]);

      var options = {
      //   title: 'สถิติฟ้องประจำวัน',
        pieHole: 0.4,
        width: 550,
        height: 400,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }
  </script>

  <script type="text/javascript">
      google.charts.load("current", {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
          var data = google.visualization.arrayToDataTable([
              ["ประเภทสัญญา", "จำนวน", { role: "style" } ],
              ["กู้-บุคคล", {{$countPerson}}, "blue"],
              ["กู้-ทรัพย์", {{$countProperty}}, "red"]
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                          { calc: "stringify",
                              sourceColumn: 1,
                              type: "string",
                              role: "annotation" },
                          2]);

          var options = {
              // title: "แผนภูมิแท่ง",
              width: 400,
              height: 400,
              bar: {groupWidth: "95%"},
              legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
          chart.draw(view, options);
      }
  </script>
@endif

@endsection
