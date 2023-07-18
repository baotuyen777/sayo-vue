<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdws extends Model
{
    use HasFactory;

    public function district()
    {
        return $this->belongsTo(Pwds::class,'parent_id');
    }

//    public func
}
