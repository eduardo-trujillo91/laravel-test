<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    protected $table = 'customers';

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'firstName', 'lastName', 'dateOfBirth',
        'status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Products', 'customer');
    }
}
