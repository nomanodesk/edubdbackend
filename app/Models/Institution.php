<?php

namespace App\Models;
use App\Models\InstituteClass;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $fillable = ['instituteName','nameCode','EIIN','logo','contactNo','address','user_id'];
    
    public function institute_classes()
    {
        return $this->hasMany(InstituteClass::class, 'institution_id', 'id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'institution_id', 'id');
    }
}
