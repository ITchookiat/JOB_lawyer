@extends('layouts.master')
@section('title','ข้อมูลหลัก')
@section('content')

  <!-- Main content -->
  <section class="content">
    <div class="content-header">
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
            <li>กรุณากรอกข้อมูลให้ครบช่อง {{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="" style="text-align:center;"><b>ข้อมูลสมาชิกผู้ใช้งาน</b></h3>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-12"> <br />
                    <form method="post" action="{{ action('UserController@update',$id) }}" enctype="multipart/form-data">
                      @csrf
                      @method('put')

                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>Username : </label>
                            <input type="text" name="main_username" class="form-control" style="width: 400px;" placeholder="ป้อนชื่อผู้ใช้" value="{{$user->username}}" />
                          </div>
                        </div>
                      </div>
    
                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>Name : </label>
                            <input type="text" name="main_name" class="form-control" style="width: 400px;" placeholder="ป้อนชื่อ" value="{{$user->name}}" />
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>Enail : </label>
                            <input type="text" name="main_email" class="form-control" style="width: 400px;" placeholder="ป้อนอีเมลล์" value="{{$user->email}}" />
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>แผนก : </label>
                            <select name="section_type" class="form-control" style="width: 400px;">
                              <option value="" selected>--------- แผนก ----------</option>
                              <option value="Admin" {{ ($user->type === 'Admin') ? 'selected' : '' }}>Admin</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <br>
                      <div class="row">
                        <div class="col-8">
                          <div class="float-right form-inline">
                            <label>ตำแหน่ง : </label>
                            <select name="branch" class="form-control" style="width: 400px;">
                              <option value="" selected>--------- ตำแหน่ง ----------</option>
                              <option value="Admin" {{ ($user->branch === 'Admin') ? 'selected' : '' }}>Admin</option>
                              <option value="MANAGER" {{ ($user->branch === 'MANAGER') ? 'selected' : '' }}>MANAGER</option>
                              <option value="AUDIT" {{ ($user->branch === 'AUDIT') ? 'selected' : '' }}>AUDIT</option>
                              <option value="MASTER" {{ ($user->branch === 'MASTER') ? 'selected' : '' }}>MASTER</option>
                              <option value="STAFF" {{ ($user->branch === 'STAFF') ? 'selected' : '' }}>STAFF</option>
                            </select>
                          </div>
                        </div>
                      </div>
    
                      <br>
                      <div class="form-group" align="center">
                        <button type="submit" class="delete-modal btn btn-success">
                          <span class="glyphicon glyphicon-floppy-save"></span> อัพเดท
                        </button>
                        <a class="delete-modal btn btn-danger" href="{{ route('ViewMaindata') }}">ยกเลิก</a>
                      </div>
                      <input type="hidden" name="_method" value="PATCH"/>
                    </form>
    
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <script>
    $(".alert").fadeTo(3000, 500).slideUp(500, function(){
    $(".alert").alert('close');
    });;
  </script>

@endsection
