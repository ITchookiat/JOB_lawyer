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
                        <div class="row">
                            <section class="col-lg-8 connectedSortable ui-sortable">
                                <div class="card card-primary">
                                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                                        <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        สถิติการฟ้อง
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
                                                    <div id="donutchart" align="center" style="width: 700px; height: 400px;"></div>
                                                </div>
                                                <div class="tab-pane" id="tab_2">
                                                    <div id="columnchart_values" style="width: 700px; height: 400px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>          
                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                            รายการฟ้องล่าสุด
                                        </h3>

                                        <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0" style="display: block;">
                                        <ul class="products-list product-list-in-card pl-2 pr-2">
                                        @foreach($data as $key => $row)
                                            <li class="item">
                                                <div class="product-img text-center">
                                                <!-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> -->
                                                    @if($row->Type_Cus == 'กู้-บุคคล')
                                                        <i class="fas fa-address-book fa-3x" title="กู้-บุคคล"></i>
                                                    @elseif($row->Type_Cus == 'กู้-ทรัพย์')
                                                        <i class="fas fa-suitcase fa-3x" title="กู้-ทรัพย์"></i>
                                                    @endif
                                                </div>
                                                <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">{{$row->Number_Cus}}
                                                    <span class="badge badge-warning float-right">ชั้นศาล</span></a>
                                                <span class="product-description">
                                                {{$row->Name_Cus}}
                                                </span>
                                                </div>
                                            </li>
                                            <!-- /.item -->
                                        @endforeach
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center" style="display: block;">
                                        <a href="{{ route('Debtor', 1) }}" class="uppercase">ดูทั้งหมด</a>
                                    </div>
                                </div> 
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['ปัตตานี', 11],
          ['ยะลา', 2],
          ['รูสะมิแล', 2],
          ['สาขาหนึ่ง', 5],
          ['สาขาสอง', 6],
          ['สาขาสาม', 3],
          ['สาขาสี่', 1],
          ['สาขาห้า', 2],
          ['สาขาหก', 7]
        ]);

        var options = {
        //   title: 'สถิติฟ้องประจำวัน',
          pieHole: 0.4,
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
            ["Element", "Density", { role: "style" } ],
            ["ปัตตานี", 8.94, "#b87333"],
            ["ยะลา", 10.49, "silver"],
            ["รูสะมิแล", 19.30, "gold"],
            ["สาขาหนึ่ง", 15.30, "gold"],
            ["สาขาสอง", 10.30, "gold"],
            ["สาขาสาม", 11.30, "gold"],
            ["สาขาสี่", 7.30, "gold"],
            ["สาขาห้า", 19.30, "gold"],
            ["สาขาหก", 21.45, "color: #e5e4e2"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" },
                        2]);

        var options = {
            title: "Density of Precious Metals, in g/cm^3",
            width: 750,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
    </script>

@endsection
