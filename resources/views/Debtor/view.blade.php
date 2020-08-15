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
                            <th class="text-center" >จำนวนเงิน</th>
                            <th class="text-center" >ประเภทสัญญา</th>
                            <th class="text-center" >สถานะ</th> 
                            <th class="text-center" ></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $row)
                            <tr>
                              <td class="text-center">{{$key+1}}</td>
                              <td class="text-left">{{$row->Number_Cus}}</td>
                              <td class="text-left">{{$row->Name_Cus}}</td>
                              <td class="text-right">{{number_format($row->Principle_Cus,2)}}</td>
                              <td class="text-center">
                                <button type="button" class="btn btn-success btn-xs">
                                  <i class="fas fa-user-check prem"></i> {{$row->Type_Cus}}
                                </button>
                              </td>
                              <td class="text-center">
                                -
                              </td>
                              <td class="text-right">
                                <a href="{{ action('DebtorController@edit',[$type,$row->Cus_id]) }}" class="btn btn-warning btn-sm" title="แก้ไขรายการ">
                                  <i class="far fa-edit"></i> แก้ไข
                                </a>
                                <form method="post" class="delete_form" action="{{ action('DebtorController@destroy',[$type,$row->Cus_id]) }}" style="display:inline;">
                                {{csrf_field()}}
                                  <input type="hidden" name="_method" value="DELETE" />
                                  <button type="submit" data-name="เลขที่สัญญา : {{$row->Number_Cus}}" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                                    <i class="far fa-trash-alt"></i> ลบ
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
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
  <form name="form2" action="{{ route('MasterDeptor.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="modal fade" id="modal-add" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-xl">
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
                        <label class="col-sm-4 col-form-label text-right">ชื่อ-สกุลผู้กู้:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Namedeptor" class="form-control" placeholder="ป้อนชื่อ-สกุลผู้กู้" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label text-right">เลขที่สัญญา :</label>
                          <div class="col-sm-8">
                            <input type="text" name="Contractdeptor" class="form-control" placeholder="ป้อนเลขที่สัญญา" maxlength="17"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6"></div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label text-right">ประเภทสัญญา :</label>
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
                        <label class="col-sm-4 col-form-label text-right">ชื่อ-สกุลผู้ค้ำ:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Namesurety" class="form-control" placeholder="ป้อนชื่อ-สกุลผู้ค้ำ"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                          <label class="col-sm-3 col-form-label text-right">ที่อยู่ :</label>
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
                          <label class="col-sm-4 col-form-label text-right">ชื่อ-สกุลผู้จำนอง:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Namemortgager" class="form-control" placeholder="ป้อนชื่อ-สกุลผู้จำนอง"/>
                          </div>
                          <label class="col-sm-4 col-form-label text-right">เลขที่โฉนด:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Noland" class="form-control" placeholder="ป้อนเลขที่โฉนด"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row mb-1">
                          <label class="col-sm-3 col-form-label text-right">ที่อยู่ :</label>
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
    function addcomma(){
      var num11 = document.getElementById('Amountdeptor').value;
      var num1 = num11.replace(",","");
      document.form2.Amountdeptor.value = addCommas(num1);
    }
  </script>

@endsection
