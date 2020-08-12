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
                  @if($type == 1)
                    <h4 class="" style="text-align:center;"><b>ติดตามลูกหนี้</b></h4>
                  @endif
                </div>
                <div class="card-body text-sm">
                  @if($type == 1)
                    <form method="get" action="#">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="float-right form-inline">
                            <a class="btn bg-primary btn-app" data-toggle="modal" data-target="#modal-add" data-backdrop="static">
                              <span class="fas fa-plus"></span> เพิ่มรายการ
                            </a>
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
                            <input type="date" name="Fromdate" value="{{ date('Y-m-d') }}" class="form-control" />
                            <label>ถึงวันที่ : </label>
                            <input type="date" name="Todate" value="{{ date('Y-m-d') }}" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </form>
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

                        </tbody>
                      </table>
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
