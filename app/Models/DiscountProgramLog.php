<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountProgramLog extends Model
{
    protected $table = 'discount_program_logs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_id', 'discount_id', 'device', 'last_used_at'
    ];


    public function memberData()
    {
        return $this->belongsTo('App\Models\Member', 'membership_id', 'id');
    }
}
