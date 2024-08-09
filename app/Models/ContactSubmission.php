<?php

namespace App\Models;

use App\Traits\hasulid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactSubmission extends Model
{
    use HasFactory;
    use hasulid;

    protected $guarded = [];
}
