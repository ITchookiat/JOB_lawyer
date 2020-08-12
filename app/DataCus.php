<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataCus extends Model
{
    protected $table = 'data_cuses';
    protected $primaryKey = 'DataCus_id';
    protected $fillable = ['DataCus_id','Name_Cus','Number_Cus','Cash_Cus','Address_Cus','Type_Cus',
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

