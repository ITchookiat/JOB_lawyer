<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSuretys extends Model
{
    protected $table = 'data_suretys';
    protected $primaryKey = 'DataCus_id';
    protected $fillable = ['DataCus_id','Name_Surety','Address_Surety','NameUser','DateUser'];

    public function DataCus()
    {
      return $this->belongsTo(DataCus::class,'DataCus_id');
    }
}
