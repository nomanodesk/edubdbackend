<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\NoticeBoard;

class USSDController extends Controller

{
    public function ussdreceiver(Request $request){

        $ussdserverurl= 'https://api.applink.com.bd/ussd/send';
        $receiverSessionId    =   $request->input('sessionId');
        $content 			    = 	$request->input('message'); 
        $address 			    = 	$request->input('sourceAddress');
        $requestId 			= 	$request->input('requestId'); 
        $applicationId 		= 	$request->input('statusCode');
        $encoding 			=	$request->input('encoding');
        $version 			    = 	$request->input('version');
        $sessionId 			= 	$request->input('sessionId');
        $ussdOperation 		= 	$request->input('ussdOperation'); 
         
        $responseMsg = array(
            "main" => "Welcome : Enter Your School Code",
            "unsubscribe" => "You will get a confirmation SMS soon",
            "select_school" => "স্কুল কোড দিন
                                0.পিছনে",
            "select_option" => "Enter Your Choice
                    1.Class Notice 
                    0.Back",

            "goodbye"=>"Good Bye!!! have a nice day"
        );  
        if ($ussdOperation  == "mo-init") {
            try {
            // $ussdSender->ussd($sessionId, $responseMsg["main"] ,$address);
            
                    $ussdOpssend  = "mo-init";
					$ch = curl_init($ussdserverurl);
					$version = "1.0";
					$data = array("applicationId" => 'APP_003242', "password" => '5538bf24fb2c913ed908b7fa22e54447',"message" => $responseMsg["main"],"sessionId" => $sessionId,"ussdOperation"=> $ussdOpssend, "destinationAddress" => $address);
					$payload = json_encode($data);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					curl_close($ch);
            } catch (Exception $e) {
                    // $ussdSender->ussd($sessionId, 'Sorry error occurred try again',$address );
            }
        }
            elseif ($ussdOperation == "mo-cont") {
                if (!(isset($_SESSION['menu-Opt']))) {
                    $_SESSION['menu-Opt'] = "main"; 
                }
            $menuName = null;
            switch ($_SESSION['menu-Opt']) {
                    case "main":
                            switch ($content) {
                            
                                case "$content":
                                    $school = Institution::where('nameCode', $content)->get();
                                    
                                    if($school){
                                    foreach($school as $data){
                                    $school_id= $data['id'];
                                    // $code = $data['code'];
                                    // $_SESSION['code'] = $data['code'];
                                    }
                                    $notice = NoticeBoard::where('id', $school_id)->get();
                                    // $classes .= $name." Notice Board:".PHP_EOL."";
                                    // foreach($get_classes as $row){
                                    // $classes .= $row['press_key'].') Class '.$row['class_name'].PHP_EOL;
                                    //     echo "<br>";
                                    $ussdOpssend  = "mo-cont";
                                    $ch = curl_init($ussdserverurl);
                                    $version = "1.0";
                                    $data = array("applicationId" => 'APP_003242', "password" => '5538bf24fb2c913ed908b7fa22e54447',"message" => $notice,"sessionId" => $sessionId,"ussdOperation"=> $ussdOpssend, "destinationAddress" => $address);
                                    $payload = json_encode($data);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $result = curl_exec($ch);
                                    curl_close($ch);    
                                }
                                    
                                    
                                    // $ussdSender->ussd($sessionId, $responseMsg["select_option"] ,$address);

                                    // if($content == '1'){
                                    // $scode = $_SESSION['code'];
                                    // $get_classes = $school->getreport('class',"*","school_code='$scode'");
                                    // $classes .= $name." Notice Board:".PHP_EOL."";
                                    // foreach($get_classes as $row){
                                    // $classes .= $row['press_key'].') Class '.$row['class_name'].PHP_EOL;
                                    //     echo "<br>";
                                    // }
                                    // $ussdSender->ussd($sessionId, $classes ,$address);
                                    // }
                                    // }else{
                                    //         $error = "স্কুল কোড ভুল হয়েছে। আবার চেষ্টা করুন।";
                                    //         $ussdSender->ussdfin($sessionId, $error ,$address);
                                    // }
                                    
                                    break;

                    
                        
                            case "0":
                                            $menuName = "goodbye";
                                            break;
                            default:
                                            $menuName = "main";
                                            break;
                                }
                    // case "select_option":
                    //         switch ($content) {
                    //         case "1" :
                                
                    //                 $scode = $_SESSION['code'];
                    //                 $get_classes = $school->getreport('class',"*","school_code='$scode'");
                    //                 $classes .= $name." Notice Board:".PHP_EOL."";
                    //                 foreach($get_classes as $row){
                    //                 $classes .= $row['press_key'].') Class '.$row['class_name'].PHP_EOL;
                    //                     echo "<br>";
                    //                 }
                    //                 $ussdSender->ussd($sessionId, $classes ,$address);
                                
                    //             $mssg = $school->getreport('class_notice',"*","press_key='$content' AND school_code='SC001'");
                    //             foreach($mssg as $row){
                    //             $report = $row['notice'];
                    //             }
                    //             $ussdSender->ussdfin($sessionId, $report ,$address);
                                
                    //             break;
                    //         }				

                        $_SESSION['menu-Opt'] = $menuName; 
                        break;
                
                }
                // schoollog("Selected response message := " . $content.$responseMsg[$menuName]);
                // $ussdSender->ussd($sessionId,$responseMsg[$menuName],$address);
                $ch = curl_init($ussdserverurl);
                                    $version = "1.0";
                                    $data = array("applicationId" => 'APP_003242', "password" => '5538bf24fb2c913ed908b7fa22e54447',"message" => $responseMsg[$menuName],"sessionId" => $sessionId,"ussdOperation"=> $ussdOpssend, "destinationAddress" => $address);
                                    $payload = json_encode($data);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $result = curl_exec($ch);
                                    curl_close($ch);   
                }
            }

    
}


