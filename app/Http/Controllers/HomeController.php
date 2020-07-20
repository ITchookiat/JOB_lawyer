<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\data_car;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($name)
    {
        date_default_timezone_set('Asia/Bangkok');
        $Y = date('Y');
        $m = date('m');
        $d = date('d');
        $date = $Y.'-'.$m.'-'.$d;
        $newdate = date('Y-m-d', strtotime('+3 days'));

        // ระบบรถบ้าน
        $data1 = 6; //รถในสต็อกทั้งหมด
        $data2 = 2; //ระหว่างทำสี
        $data3 = 3; //รอซ่อม
        $data4 = 4; //ระหว่างซ่อม
        $data5 = 5; //พร้อมขาย
        $data6 = 1; //ขายแล้ว
        // $data6 = data_car::where('car_type', '=', 6 )->count(); //ขายแล้ว
        
        return view($name, compact('data1','data2','data3','data4','data5','data6'));
    }
}
