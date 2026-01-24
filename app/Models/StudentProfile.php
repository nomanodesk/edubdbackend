<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;
use App\Models\StudentSchoolData;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentProfile extends Model
{
    use HasFactory;
    protected $fillable =
    ['studentName', 'studentImage','address','uid','contactNo', 'institution_id', 'operator_id'];
    public function institute()
    {
        return $this->belongsTo(Institution::class, 'institution_id', 'id');
    }
    public function studentdata(): HasOne
    {
        return $this->hasOne(StudentSchoolData::class);
    }
    public function schoolData()
{
    return $this->hasOne(StudentSchoolData::class, 'student_id');
}

}
