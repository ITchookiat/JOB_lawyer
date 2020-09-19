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
                        <h4>
                        @if($type == 1)
                          <h4 class="" style="text-align:center;"><b>รายงานลูกหนี้ กู้-บุคคล</b></h4>
                        @elseif($type == 2)
                          <h4 class="" style="text-align:center;"><b>รายงานลูกหนี้ กู้-ทรัพย์</b></h4>
                        @elseif($type == 3)
                        <h4 class="" style="text-align:center;"><b>รายงานลูกหนี้สืบทรัพย์</b></h4>
                        @elseif($type == 4)
                        <h4 class="" style="text-align:center;"><b>รายงานเบิกค่าใช้จ่ายลูกหนี้</b></h4>
                        @elseif($type == 5)
                        <h4 class="" style="text-align:center;"><b>รายงานลูกหนี้ปิดจบงาน</b></h4>
                        @endif
                        </h4>
                      </div>
                    </div>
                    <!-- <div class="col-4">
                      <div class="card-tools d-inline float-right">
                        @if(auth::user()->type == "Admin")
                          <a class="btn bg-danger btn-sm" data-toggle="modal" data-target="#modal-newcar" data-backdrop="static" data-keyboard="false">
                            <span class="fas fa-print"></span> ปริ้น
                          </a>
                        @endif
                      </div>
                    </div> -->
                  </div>
                </div>
                <div class="card-body text-sm">
                  <form method="get" action="#">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="float-right form-inline">
                          <div class="btn-group">
                            <button type="button" class="btn bg-primary btn-app" data-toggle="dropdown">
                              <span class="fas fa-print"></span> ปริ้นรายงาน
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a target="_blank" class="dropdown-item" href="#"><i class="fas fa-file-pdf text-red"></i> &nbsp;Export PDF</a></li>
                              <li class="divider"></li>
                              <li><a target="_blank" class="dropdown-item" href="#"><i class="fas fa-file-excel text-green"></i> &nbsp;Export EXCEL</a></li>
                            </ul>
                          </div>
                          <button type="submit" class="btn bg-warning btn-app">
                            <span class="fas fa-search"></span> Search
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="float-right form-inline">
                          <label>จากวันที่ : </label>
                          <input type="date" name="Fromdate" value="" class="form-control" />

                          <label>ถึงวันที่ : </label>
                          <input type="date" name="Todate" value="" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </form>
                  <hr>
                  @if($type == 1)
                    <div class="table-responsive">
                      <table id="table1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center" >ลำดับ</th>
                            <th class="text-center" >วันที่ฟ้อง</th>
                            <th class="text-center" >เลขที่สัญญา</th>
                            <th class="text-center" >ชื่อ - นามสกุล</th>
                            <!-- <th class="text-center" >เลขที่สมาชิก</th>
                            <th class="text-center" >วันทำสัญญา</th>-->
                            <th class="text-center" >ศาล</th>
                            <th class="text-center" >จำนวนเงิน</th>
                            {{-- <th class="text-center" >ประเภทสัญญา</th> --}}
                            <th class="text-center" >สถานะ</th> 
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $row)
                            <tr>
                              <td class="text-center">{{$key+1}}</td>
                              <td class="text-center"></td>
                              <td class="text-left">
                                {{$row->Number_Cus}}
                                @if($row->Type_Cus == "กู้-บุคคล")
                                  <span class="badge bg-warning prem">กู้-บุคคล</span>
                                @elseif($row->Type_Cus == "กู้-ทรัพย์")
                                  <span class="badge bg-info prem">กู้-ทรัพย์</span>
                                @endif
                              </td>
                              <td class="text-left">{{$row->Name_Cus}}</td>
                              <td class="text-left"></td>
                              <td class="text-right">{{number_format($row->Principle_Cus,2)}}</td>
                              <td class="text-center">
                                -
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @elseif($type == 2)
                    <div class="table-responsive">
                      <table id="table1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center" >ลำดับ</th>
                            <th class="text-center" >วันที่ฟ้อง</th>
                            <th class="text-center" >เลขที่สัญญา</th>
                            <th class="text-center" >ชื่อ - นามสกุล</th>
                            <!-- <th class="text-center" >เลขที่สมาชิก</th>
                            <th class="text-center" >วันทำสัญญา</th>-->
                            <th class="text-center" >จำนวนเงิน</th>
                            {{-- <th class="text-center" >ประเภทสัญญา</th> --}}
                            <th class="text-center" >สถานะ</th> 
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $row)
                            <tr>
                              <td class="text-center">{{$key+1}}</td>
                              <td class="text-center"></td>
                              <td class="text-left">
                                {{$row->Number_Cus}}
                                @if($row->Type_Cus == "กู้-บุคคล")
                                  <span class="badge bg-warning prem">กู้-บุคคล</span>
                                @elseif($row->Type_Cus == "กู้-ทรัพย์")
                                  <span class="badge bg-info prem">กู้-ทรัพย์</span>
                                @endif
                              </td>
                              <td class="text-left">{{$row->Name_Cus}}</td>
                              <td class="text-right">{{number_format($row->Cash_Cus,2)}}</td>
                              <td class="text-center">
                                -
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @elseif($type == 3)
                    รายงานลูกหนี้สืบทรัพย์
                  @elseif($type == 4)
                    รายงานเบิกค่าใช้จ่ายลูกหนี้
                  @elseif($type == 5)
                    รายงานลูกหนี้ปิดจบงาน
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

  <script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
  </script>

@endsection
