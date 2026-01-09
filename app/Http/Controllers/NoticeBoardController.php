<?php

namespace App\Http\Controllers;

use App\Models\InstituteClass;
use Illuminate\Http\Request;
use App\Models\NoticeBoard;
use App\Models\StudentProfile;
use App\Models\StudentSchoolData;
use Auth;
use GuzzleHttp\Client;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticeboard = NoticeBoard::where('institution_id', Auth::user()->Institution->id)->get();
        // dd($noticeboard);
       
        if($noticeboard->isEmpty()){
            return view('admin.notices.createnoticeboard');
        }
         else {
            return view('admin.notices.noticeboard', compact('noticeboard'));
        }
    }
    public function noticepage(Request $request)
    {
        $student = StudentProfile::where('id', $request->id)->get();
     
        return view('admin.notices.studentnotice', compact('student'));
       
    }
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.noticeboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                
            'institution_id' => 'required',
            'description' => 'required',
      
        ]);
  
        $input = $request->all();
        NoticeBoard::create($input);
        return redirect()->route('notice_boards.index')->with('success', 'Notice Board has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NoticeBoard $notice_board)
    {
        // dd($request);
        $notice_board->update($request->all());
    
        return redirect()
            ->route('notice_boards.index')
            ->with('success', 'Notice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function sendGenNotice(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'description' => 'required',
        ]);
        $content = $request->input('description');
       
        $students = StudentProfile::where('institution_id', Auth::user()->Institution->id)->get();
        foreach ($students as $row) {
            $operator = $row['operator_id'];
            $contact = $row['contactNo'];
        $client = new Client();
        if($operator == 'Banglalink'){
        $response = $client->post('https://api.applink.com.bd/sms/send', [
            "json" => [
                "version" => "1.0",
                "applicationId" => env('EDUB_APP_ID'),
                "password" => env('EDUB_PASSWORD'),
                "message" => "$content",
                "destinationAddresses" => [
                    "tel:88$contact"
                ]

            ]
        ]);
    
        $jsonResponse = json_decode($response->getBody(), true);
       
        // print_r($jsonResponse);
        if ($jsonResponse['statusCode'] == 'S1000') {
            // print_r($jsonResponse);
            return redirect()->route('notice_boards.index')->with('success', 'SMS Sent Successfully || '.$jsonResponse['statusDetail'].' || '.$jsonResponse['statusCode'])->withInput();
        } 
        // else if ($jsonResponse['statusCode'] == 'E1300') {
        //     return back()->with('error', 'ERROR SENDING SMS!!! PLEASE CONTACT APPLNK SUPPORT WITH ERROR CODE : ' . $jsonResponse['statusCode'])->withInput();
        // }
        // else if ($jsonResponse['statusCode'] == 'E1311') {
        //     return back()->with('error', 'ERROR SENDING SMS!!! PLEASE CONTACT APPLNK SUPPORT WITH ERROR CODE : ' . $jsonResponse['statusCode'])->withInput();
        // }
    }
    // elseif($operator == 'Robi'){
    //     $response = $client->post('https://developer.bdapps.com/sms/send', [
    //         "json" => [
    //             "version" => "1.0",
    //             "applicationId" => "$appID",
    //             "password" => "$appPass",
    //             "message" => "$content",
    //             "destinationAddresses" => [
    //                 "tel:all"
    //             ]

    //         ]
    //     ]);
    //     $jsonResponse = json_decode($response->getBody(), true);
    //     // print_r($jsonResponse);
    //     // if ($jsonResponse['statusCode'] == 'S1000') {
    //     //     // print_r($jsonResponse);
    //     //     return redirect()->route('apps.index')->with('success', 'SMS Sent Successfully || '.$jsonResponse['statusDetail'].' || '.$jsonResponse['statusCode'])->withInput();
    //     // }
    //     // else if ($jsonResponse['statusCode'] == 'E1311') {
    //     //     return back()->with('error', 'ERROR SENDING SMS!!! PLEASE CONTACT BDAPPS SUPPORT WITH ERROR CODE : ' . $jsonResponse['statusCode'])->withInput();
    //     // }
    //  }
    }
    }
    public function sendStudentNotice(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'notice' => 'required',
        ]);
        $content = $request->input('notice');
       
        $student = StudentProfile::where('id', $request->input('student_id'))->get();
        foreach ($student as $row) {
            $operator = $row['operator_id'];
            $contact = $row['contactNo'];
        $client = new Client();
        if($operator == 'Banglalink'){
        $response = $client->post('https://api.applink.com.bd/sms/send', [
            "json" => [
                "version" => "1.0",
                "applicationId" => env('EDUB_APP_ID'),
                "password" => env('EDUB_PASSWORD'),
                "message" => "$content",
                "destinationAddresses" => [
                    "tel:88$contact"
                ]

            ]
        ]);
    
        $jsonResponse = json_decode($response->getBody(), true);
       
        // print_r($jsonResponse);
        if ($jsonResponse['statusCode'] == 'S1000') {
            // print_r($jsonResponse);
            return redirect()->route('student_profiles.index')->with('success', 'SMS Sent Successfully || '.$jsonResponse['statusDetail'].' || '.$jsonResponse['statusCode'])->withInput();
        } 
        // else if ($jsonResponse['statusCode'] == 'E1300') {
        //     return back()->with('error', 'ERROR SENDING SMS!!! PLEASE CONTACT APPLNK SUPPORT WITH ERROR CODE : ' . $jsonResponse['statusCode'])->withInput();
        // }
        // else if ($jsonResponse['statusCode'] == 'E1311') {
        //     return back()->with('error', 'ERROR SENDING SMS!!! PLEASE CONTACT APPLNK SUPPORT WITH ERROR CODE : ' . $jsonResponse['statusCode'])->withInput();
        // }
    }
    // elseif($operator == 'Robi'){
    //     $response = $client->post('https://developer.bdapps.com/sms/send', [
    //         "json" => [
    //             "version" => "1.0",
    //             "applicationId" => "$appID",
    //             "password" => "$appPass",
    //             "message" => "$content",
    //             "destinationAddresses" => [
    //                 "tel:all"
    //             ]

    //         ]
    //     ]);
    //     $jsonResponse = json_decode($response->getBody(), true);
    //     // print_r($jsonResponse);
    //     // if ($jsonResponse['statusCode'] == 'S1000') {
    //     //     // print_r($jsonResponse);
    //     //     return redirect()->route('apps.index')->with('success', 'SMS Sent Successfully || '.$jsonResponse['statusDetail'].' || '.$jsonResponse['statusCode'])->withInput();
    //     // }
    //     // else if ($jsonResponse['statusCode'] == 'E1311') {
    //     //     return back()->with('error', 'ERROR SENDING SMS!!! PLEASE CONTACT BDAPPS SUPPORT WITH ERROR CODE : ' . $jsonResponse['statusCode'])->withInput();
    //     // }
    //  }
    }
    }

    ##Class Notice Operations
    public function classnoticepage(Request $request)
    {
    //     $class = InstituteClass::where('id', $request->id)->get();
    //  dd($class);
    
    $class = StudentProfile::select(
        'student_profiles.*',
        'student_school_data.*',
        'class_sections.*'
    )
    ->join('student_school_data', 'student_profiles.id', '=', 'student_school_data.student_id')
    ->join('class_sections','class_sections.id','=','student_school_data.class_section_id')
    ->where('student_school_data.institue_class_id', $request->id)
    ->get();
    // dd($class);
    if ($class->isEmpty()) {
        return redirect()->back()
        ->with('popup_error', 'No students found in this class')
        ->withInput();}else{
        return view('admin.notices.classnotice', compact('class'));
    }  
       
    }
    
    public function classStudentNotice(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'notice' => 'required',
            'class_version' => 'required',
            'class_shift' => 'required',
        ]);
     
        $content = $request->input('notice');
       
    
        $class_students = StudentSchoolData::select(
                'student_profiles.*',
                'student_school_data.*',
                'class_sections.*'
            )
            ->join('student_profiles', 'student_profiles.id', '=', 'student_school_data.student_id')
            ->join('class_sections','class_sections.id','=','student_school_data.class_section_id')
            ->where('student_school_data.class_section_id',$request->input('class_id') )
            ->where('class_sections.class_shift', $request->input('class_shift'))
            ->where('class_sections.class_version', $request->input('class_version'))
            ->get();
        // dd($class_students);
        if ($class_students->isEmpty()) {
            return redirect()->back()
        ->with('popup_error', 'No students found')
        ->withInput();}else{
        $client = new Client(); // create once
        
        $successCount = 0;
        $failCount = 0;
    
        foreach ($class_students as $row) {
    
            $operator = $row->operator_id;
            $contact  = $row->contactNo;
    
            if ($operator == 'Banglalink' && !empty($contact)) {
    
                try {
                    $response = $client->post('https://api.applink.com.bd/sms/send', [
                        "json" => [
                            "version" => "1.0",
                            "applicationId" => env('EDUB_APP_ID'),
                            "password" => env('EDUB_PASSWORD'),
                            "message" => $content,
                            "destinationAddresses" => [
                                "tel:88{$contact}"
                            ]
                        ]
                    ]);
    
                    $jsonResponse = json_decode($response->getBody(), true);
    
                    if (isset($jsonResponse['statusCode']) && $jsonResponse['statusCode'] == 'S1000') {
                        $successCount++;
                    } else {
                        $failCount++;
                    }
    
                } catch (\Exception $e) {
                    $failCount++;
                    \Log::error('SMS Failed for '.$contact.' : '.$e->getMessage());
                }
    
            } // end if
    
        } // end foreach
    
        return redirect()->route('classnoticereport')->with('success', "SMS sent: {$successCount}, Failed: {$failCount}");
     }
    

    }
    public function classnoticereport(Request $request)
    {
        $instituteclasses = InstituteClass::where('institution_id', Auth::user()->Institution->id)->simplepaginate(100);
        // dd($findinstitue);
        if ($instituteclasses->isEmpty()) {
            return view('admin.class.addclass');
        } else {
            return view('admin.class.listclass', compact('instituteclasses'))->with('i', (request()->input('page', 1) - 1) * 100);
        }
       
    }
    
}
