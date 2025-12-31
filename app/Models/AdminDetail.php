<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminDetail extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_details';

    protected $primaryKey = 'id'; // Adjust if different

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];

    protected $hidden = [
        'admin_password',
    ];

    /**
     * Get the password for authentication
     */
    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    /**
     * Get the column name for the "username" (login field)
     */
    public function getAuthIdentifierName()
    {
        return 'admin_login_id';
    }

    /**
     * Get the unique identifier for the user
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }
}