<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassCourtCase extends Model
{
    protected $table = 'class_court_cases';
    protected $primaryKey = 'Cases_id';
    protected $fillable = ['DataCus_id','DateDeed','NoteDocCase','seizure','Selling','resultsSell','Datesoldout','AmountSell',
                           'DatePrice','CountSelling','Cashpay'];

    public function DataCus()
    {
      return $this->belongsTo(DataCus::class,'DataCus_id');
    }
}
