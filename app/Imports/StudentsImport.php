<?php

namespace App\Imports;

use App\Models\StudentProfile;
use App\Models\StudentSchoolData;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    protected $classSectionId;
    protected $institueClassId;

    public function __construct($classSectionId, $institueClassId)
    {
        $this->classSectionId = $classSectionId;
        $this->institueClassId = $institueClassId;
    }
    public function model(array $row)
    {
    //    dd($row);
        // operator detect
        $contact = $row['contactno'];
        $firstThreeDigits = substr($contact, 0, 3);
        $operator = '';

        if ($firstThreeDigits == '018') {
            $operator = "Robi";
        } elseif ($firstThreeDigits == '019') {
            $operator = "Banglalink";
        }

        // insert student_profiles
        $student = StudentProfile::create([
            'institution_id' => Auth::user()->Institution->id,
            'studentName' => $row['studentname'],
            'address' => $row['address'],
            'contactNo' => $contact,
            'operator_id' => $operator,
        ]);

        // insert student_school_data
        StudentSchoolData::create([
            'student_id' => $student->id,
            'class_section_id'  => $this->classSectionId,
            'institue_class_id'=> $this->institueClassId,
            'rollno' => $row['rollno'],
        ]);

        return null;
    }
    
    public function customValidationMessages()
    {
        return [
            'contactno.validnumber' => 'Please enter a valid Robi or Banglalink number',
            'contactno.unique' => 'This contact number already exists',
        ];
    }
    
    public function rules(): array
    {
        return [
            '*.studentname' => 'required',
            '*.address' => 'required',
            '*.contactno' => [
                'required',
                'digits:11',
                'unique:student_profiles,contactNo',
                'validnumber', // ✅ your custom rule
            ],
               
        ];
    }
}

