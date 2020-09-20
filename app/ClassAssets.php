<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassAssets extends Model
{
    protected $table = 'class_assets';
    protected $primaryKey = 'Assets_id';
    protected $fillable = ['DataCus_id','DateAssets','Determine','Consequence','Charges','NextDateAssets','NoteAssets'];

    public function DataCus()
    {
      return $this->belongsTo(DataCus::class,'DataCus_id');
    }
}
