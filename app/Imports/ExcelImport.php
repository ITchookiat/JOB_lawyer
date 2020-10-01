<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ExcelImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // dd($collection);
        $data = DB::table('law_datas')->get();
        $count_data = count($data);
        // if($count_data == 0){
        //     $upload = 1;
        // }else{
        //     $data = DB::table('law_datas')->limit(1)->orderBy('Law_id', 'desc')->get();
        //     $upload = $data[0]->Upload + 1;
        // }

        $date = date('Y-m-d');
        foreach($collection as $key => $value)
        {
            if($key > 1)
            {
                DB::table('law_datas')->insert
                (
                    [
                    'Contract_no' => $value[0],
                    'Name' => $value[1],
                    'Member_no' => $value[2],
                    'Date_contract' => $value[3],
                    'Date_firstdue' => $value[4],
                    'Date_lastdue' => $value[5],
                    'Finance_approve' => $value[6],
                    'Service_charge' => $value[7],
                    'Total_amount' => $value[8],
                    'Balance_amount' => $value[9],
                    'created_at' => $date,
                    'updated_at' => $date
                    ]
                );
            }
        }
    }

}
