<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminDiscountProgram extends Model
{
    protected $table = 'admin_discount_programs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discount_id', 'last_used_at'
    ];

}
