<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Law_data extends Model
{
    protected $table = 'law_datas';
    protected $fillable = [
         'Contract_no','Name', 'Member_no', 'Date_contract', 'Date_firstdue', 'Date_lastdue',
         'Finance_request', 'Finance_approve', 'Service_charge', 'Total_amount', 'Balance_amount',
         'Guarantor_name', 'Status_notis', 'Upload'
    ];
}
