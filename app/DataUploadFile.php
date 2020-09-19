<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataUploadFile extends Model
{
    protected $table = 'data_upload_files';
    protected $primaryKey = 'File_id';
    protected $fillable = ['DataCus_id','Type_file','Name_file','Size_file','Date_file'];

    public function DataCus()
    {
      return $this->belongsTo(DataCus::class,'DataCus_id');
    }
}
