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
                                <div class="card">
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
                                                    <div id="donutchart" align="center" style="width: 750px; height: 420px;"></div>
                                                </div>
                                                <div class="tab-pane" id="tab_2">
                                                    <div id="columnchart_values" style="width: 750px; height: 420px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>          
                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                            รายการล่าสุด
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
                                        <li class="item">
                                            <div class="product-img">
                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">Samsung TV
                                                <span class="badge badge-warning float-right">$1800</span></a>
                                            <span class="product-description">
                                                Samsung 32" 1080p 60Hz LED Smart HDTV.
                                            </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <li class="item">
                                            <div class="product-img">
                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">Bicycle
                                                <span class="badge badge-info float-right">$700</span></a>
                                            <span class="product-description">
                                                26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                            </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <li class="item">
                                            <div class="product-img">
                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">
                                                Xbox One <span class="badge badge-danger float-right">
                                                $350
                                            </span>
                                            </a>
                                            <span class="product-description">
                                                Xbox One Console Bundle with Halo Master Chief Collection.
                                            </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <li class="item">
                                            <div class="product-img">
                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">PlayStation 4
                                                <span class="badge badge-success float-right">$399</span></a>
                                            <span class="product-description">
                                                PlayStation 4 500GB Console (PS4)
                                            </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        <li class="item">
                                            <div class="product-img">
                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">PlayStation 5
                                                <span class="badge badge-success float-right">$399</span></a>
                                            <span class="product-description">
                                                PlayStation 5 1TB Console (PS5)
                                            </span>
                                            </div>
                                        </li>
                                        <!-- /.item -->
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center" style="display: block;">
                                        <a href="javascript:void(0)" class="uppercase">View All Products</a>
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
