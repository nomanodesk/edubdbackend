<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchoolData extends Model
{
    use HasFactory;
    protected $fillable = ['class_section_id','rollno','student_id','institue_class_id'];
}
