<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountProgram extends Model
{
    protected $table = 'discount_programs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_id', 'membership_type', 'discount_id', 'device', 'print_count', 'is_used', 'is_admin', 'used_at'
    ];
}
