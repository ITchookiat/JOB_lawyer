<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataMortgagers extends Model
{
    protected $table = 'data_mortgagers';
    protected $primaryKey = 'DataCus_id';
    protected $fillable = ['DataCus_id','Name_Mortgager','Address_Mortgager','NumberDeed_Mortgager','DateUser','DateUser'];

    public function DataCus()
    {
      return $this->belongsTo(DataCus::class,'DataCus_id');
    }
}
