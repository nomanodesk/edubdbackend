<?php

namespace App\Http\Controllers;

use App\Models\InstituteClass;
use App\Models\Institution;
use App\Models\StudentProfile;
use App\Models\StudentSchoolData;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;
use Image;
use App\Models\SmsHistory;
use Carbon\Carbon;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function dashboard()
     {  
        $userId = Auth::id(); // returns null if not logged in
        $institutionId = Auth::user()->Institution->id;
        $institute = Institution::where('user_id', $userId)->get();
        // dd($findinstitue);
        if($institute->isEmpty()){
            return view('admin.addinstitue');
        }
         else {
            $total_classes = InstituteClass::where('institution_id', $institutionId)->count();
            $total_students = StudentProfile::where('institution_id', $institutionId)->count();
            $smsCountThisMonth = SmsHistory::whereMonth('created_at', Carbon::now()->month)
                  ->where('institution_id', $institutionId)
                  ->count();
            // dd($total_classes);
// SQL executed: SELECT COUNT(*) FROM users WHERE status = 'active'
            $smsByOperator = DB::table('sms_histories')
                    ->select('operator', DB::raw('COUNT(*) as total'))
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->groupBy('operator')
                    ->pluck('total', 'operator');
                    
                    $rows = StudentSchoolData::join(
                        'institute_classes',
                        'student_school_data.institue_class_id',
                        '=',
                        'institute_classes.id'
                    )
                    ->join(
                        'class_sections',
                        'student_school_data.class_section_id',
                        '=',
                        'class_sections.id'
                    )
                    ->where('institute_classes.institution_id', $institutionId)
                    ->selectRaw('
                        institute_classes.class_level,
                        class_sections.class_shift,
                        COUNT(student_school_data.student_id) as total
                    ')
                    ->groupBy('institute_classes.class_level', 'class_sections.class_shift')
                    ->get();
            
                // Default structure
                $classchartData = [
                    'Primary' => ['Morning' => 0, 'Day' => 0],
                    'Secondary' => ['Morning' => 0, 'Day' => 0],
                    'Higher Secondary' => ['Morning' => 0, 'Day' => 0],
                ];
            
                foreach ($rows as $row) {
                    $classchartData[$row->class_level][$row->class_shift] = $row->total;
                }
            return view('admin.home', compact('institute','total_classes','total_students','smsCountThisMonth','smsByOperator','classchartData'));
        }
       
     }
    public function index()
    {
        // return view('admin.home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            $request->validate([
                
                'instituteName' => 'required',
                'nameCode' => 'required',
                'contactNo' => ['required', 'string', 'max:11'],
                'EIIN' => 'required',
                'address' => 'required',
                'logo'=>'required',
              
            ]);
      
            $input = $request->all();
// dd($input);
            if ($image = $request->file('logo')) {
                $path = public_path('institueLogos/');
                !is_dir($path) &&
                    mkdir($path, 0777, true);
    
                $profileImage = time() . '.' . $request->logo->extension();
                Image::make($request->file('logo'))
                    ->resize(200, 200)
                    ->save($path . $profileImage);
                $input['logo'] = "$profileImage";
            } else {
                unset($input['image']);
            }
            Institution::create($input);
    
            return redirect()->route('home')->with('success', 'Application has been created successfully.');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        //
    }
}
