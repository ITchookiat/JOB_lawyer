@extends('layouts.master')
@section('title','ชั้นบังคับคดี')
@section('content')

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
                              <a class="nav-link" href="{{ action('DebtorController@edit',[3,$data->Cus_id]) }}">สืบทรัพย์</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active" href="{{ action('DebtorController@edit',[4,$data->Cus_id]) }}">ชั้นบังคับคดี</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>          
                </div>
              </div>
              <div class="card-body">
                <form name="form1" method="post" action="{{ action('DebtorController@update',[$Gettype,$data->Cus_id]) }}" enctype="multipart/form-data">
                  @csrf
                  @method('put')

                  <h5 class="" align="left"><b>ขั้นตอนชั้นบังคับคดี</b></h5>
                  <div class="row">
                    <div class="col-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-1" data-toggle="pill" href="#tabs-1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false"><i class="fas fa-toggle-on"></i> เตรียมเอกสาร(30 วัน)</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-2" data-toggle="pill" href="#tabs-2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-toggle-on"></i> ตั้งเรื่องยึดทรัพย์(180 วัน)</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="tabs-1" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่คัดโฉนด
                                  <input type="date" id="DateDeed" name="DateDeed" class="form-control form-control-sm" value="" onchange="CourtcaseDate();" />
                                  <br>
                                </div>
                                <div class="col-md-6">
                                  หมายเหตุ
                                  <textarea name="NoteDocCase" class="form-control" rows="3"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="row">
                                <div class="col-md-6">
                                  วันที่ตั้งเรื่องยึดทรัพย์แรกเริ่ม
                                  <input type="date" id="seizure" name="seizure" class="form-control form-control-sm" value="" />
                                </div>
                                
                                <div class="col-md-6">
                                  ประกาศขาย
                                  <select id="Selling" name="Selling" class="form-control form-control-sm">
                                    <option value="" selected>--- เลือกผลการประกาศขาย ---</option>
                                    <option value="ขายได้">ขายได้</option>
                                    <option value="ขายไม่ได้">ขายไม่ได้</option>
                                  </select>
                                </div>
                              </div>

                              <script>
                                  $('#Selling').change(function(){
                                    var value = document.getElementById('Selling').value;
                                      if(value == 'ขายไม่ได้'){
                                        $('#ShowDetail1').show();
                                        $('#ShowDetail2').hide();
                                        $('#ShowSellDetail1').hide();
                                        $('#ShowSellDetail2').hide();
                                      }
                                      else if(value == 'ขายได้'){
                                        $('#ShowDetail2').show();
                                        $('#ShowDetail1').hide();
                                        $('#ShowSellDetail1').hide();
                                        $('#ShowSellDetail2').hide();
                                      }
                                      else{
                                        $('#ShowDetail1').hide();
                                        $('#ShowDetail2').hide();
                                        $('#ShowSellDetail1').hide();
                                        $('#ShowSellDetail2').hide();
                                      }
                                  });

                              </script>

                              <div class="row">
                                <div class="col-md-6">
                                  หมายเหตุ
                                  <textarea name="Notesequester" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="col-md-6">
                                  <div id="ShowDetail1" style="display:none;">
                                    <div class="row">
                                      <div class="col-md-12">
                                        วันที่จ่ายเงิน
                                        <input type="date" id="DatePrice" name="DatePrice" class="form-control form-control-sm" value="" />
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-inline">
                                          <div class="col-md-7">
                                            จำนวนครั้งประกาศขาย
                                            <input type="number" id="CountSeliing" name="CountSeliing" class="form-control form-control-sm" min="1" style="width: 130px;" value="" />
                                          </div>
                                          <div class="col-md-5">
                                            เงินค่าใช้จ่าย
                                            <input type="text" id="Cashpay" name="Cashpay" class="form-control form-control-sm" style="width: 130px;" value="" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div id="ShowDetail2" style="display:none;">
                                    <div class="row">
                                      <div class="col-md-6">
                                        ผลจากการขาย
                                        <select id="ResultSell" name="ResultSell" class="form-control form-control-sm">
                                          <option value="" selected>--- เลือกผลจากการขาย ---</option>
                                          <option value="เต็มจำนวน">เต็มจำนวน</option>
                                          <option value="ไม่เต็มจำนวน">ไม่เต็มจำนวน</option>
                                        </select>
                                      </div>
                                      <div class="col-md-6">
                                        <div id="ShowSellDetail1" style="display:none;">
                                            วันที่ขายได้
                                            <input type="date" id="Datesoldout" name="Datesoldout" class="form-control form-control-sm" value="" />
                                        </div>
      
                                        <div id="ShowSellDetail2" style="display:none;">
                                            จำนวนเงิน
                                            <input type="text" id="Amountsequester" name="Amountsequester" class="form-control form-control-sm" value="" />
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <script>
                                    $('#ResultSell').change(function(){
                                      var value = document.getElementById('ResultSell').value;
                                        if(value == 'เต็มจำนวน'){
                                          $('#ShowSellDetail1').show();
                                          $('#ShowSellDetail2').hide();
                                        }
                                        else if(value == 'ไม่เต็มจำนวน'){
                                          $('#ShowSellDetail1').hide();
                                          $('#ShowSellDetail2').show();
                                        }
                                        else{
                                          $('#ShowSellDetail1').hide();
                                          $('#ShowSellDetail2').hide();
                                        }
                                    });

                                    $('#StatusCase').change(function(){
                                      var value = document.getElementById('StatusCase').value;
                                      var today = new Date();
                                      var date = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, "0")+'-'+today.getDate().toString().padStart(2, "0");

                                      if(value == 'ถอนบังคับคดีปิดบัญชี'){
                                        $('#StatusShow1').show();
                                        $('#StatusShow2').hide();
                                        $('#StatusShow3').hide();

                                        if(value != ''){
                                          $('#DateStatusCase1').val(date);
                                        }
                                        else{
                                          $('#DateStatusCase1').val('');
                                        }
                                      }
                                      else if(value == 'ถอนบังคับคดียึดรถ'){
                                        $('#StatusShow2').show();
                                        $('#StatusShow1').hide();
                                        $('#StatusShow3').hide();

                                        if(value != ''){
                                          $('#DateStatusCase2').val(date);
                                        }
                                        else{
                                          $('#DateStatusCase2').val('');
                                        }
                                      }
                                      else if(value == 'ถอนบังคับคดียอดเหลือน้อย'){
                                        $('#StatusShow3').show();
                                        $('#StatusShow1').hide();
                                        $('#StatusShow2').hide();

                                        if(value != ''){
                                          $('#DateStatusCase3').val(date);
                                        }
                                        else{
                                          $('#DateStatusCase3').val('');
                                        }
                                      }
                                      else{
                                        $('#StatusShow1').hide();
                                        $('#StatusShow2').hide();
                                        $('#StatusShow3').hide();

                                        if(value != ''){
                                          $('#DateStatusCase3').val(date);
                                        }
                                        else{
                                          $('#DateStatusCase3').val('');
                                        }
                                      }
                                    });
                                  </script>
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
@endsection
