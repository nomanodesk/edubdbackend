<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NoticeBoard;
use App\Models\StudentProfile;
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
                "applicationId" => "APP_003242",
                "password" => "5538bf24fb2c913ed908b7fa22e54447",
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
}
