<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewLetter extends Model
{
    protected $table = 'news_letters';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_id', 'email', 'is_email_sent'
    ];
}
