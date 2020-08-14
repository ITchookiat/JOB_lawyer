<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataCus extends Model
{
    protected $table = 'data_cuses';
    protected $primaryKey = 'Cus_id';
    protected $fillable = ['DataCus_id','Name_Cus','Number_Cus','Cash_Cus','Address_Cus','Type_Cus',
                            'DateCon_Cus','Principle_Cus','Service_cus','Timeperiod_Cus','overdue_Cus','Sum_Cus','Note_Cus',
                            'Status_Cus','DateStatus_Cus','NameUser','DateUser'];

    public function DataSuretys()
    {
        return $this->hasMany(DataSuretys::class);
    }
    public function DataMortgagers()
    {
        return $this->hasMany(DataMortgagers::class);
    }
}

