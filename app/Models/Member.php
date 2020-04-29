<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'membership_type', 'discount_id', 'device', 'print_count', 'is_admin'
    ];

    public function discountListLogs (){
        return $this->hasMany('App\Models\DiscountProgramLog', 'membership_id', 'id');
    }
}
