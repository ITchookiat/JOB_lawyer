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

        $data = DB::table('data_cuses')
              ->leftjoin('data_suretys','data_cuses.Cus_id','=','data_suretys.DataCus_id')
              ->leftjoin('data_mortgagers','data_cuses.Cus_id','=','data_mortgagers.DataCus_id')
            //   ->where('cardetails.Date_Appcar','=',Null)
              ->orderBy('data_cuses.DateUser', 'DESC')
              ->limit(5)
              ->get();
            
        // $type = $request->type;
        // return view('Debtor.view', compact('data','type'));
        return view($name, compact('data'));
    }
}
