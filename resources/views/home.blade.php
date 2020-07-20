@extends('layouts.master')
@section('title','Home')
@section('content')

    <div class="content-header">
        <div class="row justify-content-center">
            <div class="col-md-12 table-responsive">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <!-- <div align="center">
                            <img class="img-responsive" src="{{ asset('dist/img/homecar.png') }}" alt="User Image" style = "width: 40%">
                        </div> -->

                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{$data1-$data6}}</h3>
                                    <p>สถิติ 1</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
                                    <a href="#" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>{{$data2}}</h3>
                                    <p>สถิติ 2</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-paint-brush fa-5x"></i>
                                </div>
                                    <a href="#" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-navy">
                                <div class="inner">
                                    <h3>{{$data3}}</h3>
                                    <p>สถิติ 3</p>
                                </div>
                                <div class="icon">
                                <i class="fas fa-car-crash"></i>
                                    <!-- <i class="fa fa-exclamation-circle fa-5x"></i> -->
                                </div>
                                    <a href="#" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><font color="white">{{$data4}}</font></h3>
                                    <p><font color="white">สถิติ 4</font></p<font>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-wrench fa-5x"></i>
                                </div>
                                    <a href="#" class="small-box-footer"><font color="white">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></font></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{$data5}}</h3>
                                    <p>สถิติ 5</p>
                                </div>
                                <div class="icon">
                                    <i class="fab fa-bitcoin"></i>
                                </div>
                                    <a href="#" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{$data6}}</h3>
                                    <p>สถิติ 6</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-cart-arrow-down"></i>
                                </div>
                                    <a href="#" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
