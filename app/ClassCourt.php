<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassCourt extends Model
{
    protected $table = 'class_courts';
    protected $primaryKey = 'Court_id';
    protected $fillable = ['DataCus_id','Datefilling','Branch','NumBlack','NumRed','Principal','Sue','Notefilling',
                           'DateExamine','NextExamine','NoteExamine',
                           'DateCompulsory','NextCompulsory','DateSentence','NoteCompulsory',
                           'DateSetofficer','NextSetofficer','NoteSetofficer',
                           'DateWarrant','NextWarrant','NoteWarrant','Warrant_Flag','DateCall','UpdateCall'];

    public function DataCus()
    {
      return $this->belongsTo(DataCus::class,'DataCus_id');
    }
}
