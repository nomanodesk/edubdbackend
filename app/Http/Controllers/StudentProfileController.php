<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\InstituteClass;
use App\Models\ClassSection;
use App\Models\StudentSchoolData;
use Illuminate\Http\Request;
use Auth;
use Image;
use App\Models\Operator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Exports\StudentsTemplateExport;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $students = StudentProfile::orderBy('id', 'desc')->where('institution_id', Auth::user()->Institution->id)->simplepaginate(100);
    //     return view('admin.student.liststudent', compact('students'))
    //         ->with('i', (request()->input('page', 1) - 1) * 100);
    // }
    public function index(Request $request)
    {
        $classes = InstituteClass::where('institution_id', Auth::user()->Institution->id)->get();
    // dd($classes);
        $students = StudentProfile::query()
            ->select(
                'student_profiles.*',
                'class_sections.sectionName',
                'class_sections.class_shift',
                'institute_classes.className'
            )
            ->join('student_school_data', 'student_school_data.student_id', '=', 'student_profiles.id')
            ->join('class_sections', 'class_sections.id', '=', 'student_school_data.class_section_id')
            ->join('institute_classes', 'institute_classes.id', '=', 'student_school_data.institue_class_id')
    
            ->when($request->institue_class_id, function ($q) use ($request) {
                $q->where('student_school_data.institue_class_id', $request->institue_class_id);
            })
            ->when($request->class_section_id, function ($q) use ($request) {
                $q->where('student_school_data.class_section_id', $request->class_section_id);
            })
            ->when($request->class_shift, function ($q) use ($request) {
                $q->where('class_sections.class_shift', $request->class_shift);
            })
    
            ->orderBy('student_profiles.id', 'desc')
            ->paginate(10)               // ✅ pagination
            ->withQueryString();         // ✅ keep filters during pagination
    
        return view('admin.student.index', compact('classes', 'students'));
    }
    
    public function getSections($classId)
{
    $sections = ClassSection::where('institue_class_id', $classId)
        ->select('id', 'sectionName', 'class_shift')
        ->orderBy('sectionName')
        ->get();

    return response()->json($sections);
}

    public function classStudents(Request $request)
    {
        $students = StudentProfile::orderBy('id', 'desc')->where('institution_id', Auth::user()->Institution->id)->simplepaginate(100);
        return view('admin.student.liststudent', compact('students'))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $operators = Operator::all();
        return view('admin.student.createstudent', compact('operators'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([

            'studentName' => 'required',
            'address' => 'required',
            // 'operator_id' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'contactNo' => 'required|validnumber|min:11|unique:student_profiles',
        ]);
        if ($validator->fails()) {
            return back()->withErrors(["error" => "Please Enter a valid Robi/Airtel/Banglalink number"])->withInput();
        }  
        $input = $request->all();
        if ($image = $request->file('studentImage')) {
            $path = public_path('studentImages/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $profileImage = time() . '.' . $request->studentImage->extension();
            Image::make($request->file('studentImage'))
                ->resize(100, 100)
                ->save($path . $profileImage);
            $input['studentImage'] = "$profileImage";
        } else {
            unset($input['image']);
        }
        Session::put('key', $input);
        $insertedData =  session('key'); 
        $classes = InstituteClass::where('institution_id', Auth::user()->id)
        ->join('class_sections','institute_classes.id', '=', 'class_sections.institue_class_id')
        ->get();
       
        return view('admin.student.addstudentclass', compact('insertedData','classes'));
    }
    public function addData(Request $request){
      
        $contact = $request->input('contactNo');
        $firstThreeDigits = substr($contact, 0, 3);
        $operator = '';
        if ($firstThreeDigits == '018') {
            $operator = "Robi";
        } else if ($firstThreeDigits == '019') {
            $operator = "Banglalink";
        }
        $data = new StudentProfile;
        $data->institution_id = $request->input('institution_id');
        $data->studentName = $request->input('studentName');
        $data->address = $request->input('address');
        $data->contactNo = $request->input('contactNo');
        $data->operator_id = $operator;
        $data->save();
        $lastId = $data->id;

        $data2 = new StudentSchoolData;
        $data2->class_section_id = $request->input('class_section_id');
        $data2->institue_class_id = $request->input('institue_class_id');
        $data2->student_id = $lastId;
        $data2->save();
        return redirect()->route('student_profiles.index')->with('success', 'Student has been created successfully.');
    
    }

    /**
     * Display the specified resource.
     */
    public function importExcel(Request $request)
{
    // dd($request->all());
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
        'class_section_id' => 'required',
        'institue_class_id' => 'required',
    ]);

    try {
        Excel::import(
            new StudentsImport(
                $request->class_section_id,
                $request->institue_class_id
            ),
            $request->file('file')
        );
        
        return back()->with('success', 'Students uploaded successfully');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        return back()->with('excelErrors', $e->failures());
    }
}

public function downloadStudentTemplate()
{
    return Excel::download(new StudentsTemplateExport, 'student_import_template.xlsx');
}

public function show(StudentProfile $studentProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = StudentProfile::with('schoolData')->findOrFail($id);
    
        $classes = InstituteClass::where(
            'institution_id',
            Auth::user()->Institution->id
        )->get();
    
        $sections = ClassSection::where(
            'institue_class_id',
            $student->schoolData->institue_class_id
        )->get();
    
        return view(
            'admin.student.edit',
            compact('student', 'classes', 'sections')
        );
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'studentName' => 'required',
        'address' => 'required',
        'contactNo' => 'required|digits:11|unique:student_profiles,contactNo,' . $id,
        'institue_class_id' => 'required',
        'class_section_id' => 'required',
    ]);

    $student = StudentProfile::findOrFail($id);

    // detect operator
    $contact = $request->contactNo;
    $operator = '';
    if (substr($contact, 0, 3) == '018') {
        $operator = 'Robi';
    } elseif (substr($contact, 0, 3) == '019') {
        $operator = 'Banglalink';
    }

    // update student profile
    $student->update([
        'studentName' => $request->studentName,
        'address' => $request->address,
        'contactNo' => $contact,
        'operator_id' => $operator,
    ]);

    // update school data
    StudentSchoolData::updateOrCreate(
        ['student_id' => $student->id],
        [
            'institue_class_id' => $request->institue_class_id,
            'class_section_id' => $request->class_section_id,
        ]
    );

    return redirect()
        ->route('student_profiles.index')
        ->with('success', 'Student updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentProfile $studentProfile)
    {
        //
    }
}
