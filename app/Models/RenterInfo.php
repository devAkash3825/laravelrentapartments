<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenterInfo extends Model
{
    use HasFactory;
    protected $table   = 'renter_info';
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ['Emove_date', 'Lmove_date', 'Reminder_date'];
    
    protected $casts = [
        'Emove_date' => 'datetime',
        'Lmove_date' => 'datetime',
    ];


    public function login()
    {
        return $this->belongsTo(Login::class, 'Login_ID', 'Id');
    }

    public function admindetails()
    {
        return $this->belongsTo(AdminDetail::class, 'added_by', 'id');
    }





}
