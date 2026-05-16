<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestItem extends Model
{
    protected $fillable = ['name','test_group_id','length'];
}
