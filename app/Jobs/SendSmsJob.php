<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SmsHistory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $student,
        public $message,
        public $key
    ) {}

    public function handle()
    {
        $client = new Client();

        try {
            if ($this->student->operator_id !== 'Banglalink') {
                throw new \Exception('Unsupported operator');
            }

            $response = $client->post('https://api.applink.com.bd/sms/send', [
                'json' => [
                    'version' => '1.0',
                    'applicationId' => env('EDUB_APP_ID'),
                    'password' => env('EDUB_PASSWORD'),
                    'message' => $this->message,
                    'destinationAddresses' => [
                        "tel:88{$this->student->contactNo}"
                    ]
                ]
            ]);
            
            $json = json_decode($response->getBody(), true);
            // dd($json);
            if (($json['statusCode'] ?? null) === 'S1000') {
          SmsHistory::create([
                'institution_id' => $this->student->institution_id,
                'phone' => $this->student->contactNo,
                'operator' => $this->student->operator_id,
                'message' => $this->message,
                'status' => 'sent',
                'response' => $response->getBody()
            ]);
            Cache::increment("sms_progress_{$this->key}_sent");
        }elseif(($json['statusCode'] ?? null) === 'E1365'){
            SmsHistory::create([
                'institution_id' => $this->student->institution_id,
                'phone' => $this->student->contactNo,
                'operator' => $this->student->operator_id,
                'message' => $this->message,
                'status' => 'unregistered',
                'response' => $response->getBody()
            ]);
            Cache::increment("sms_progress_{$this->key}_unregistered");
        } else{
            SmsHistory::create([
                'institution_id' => $this->student->institution_id,
                'phone' => $this->student->contactNo,
                'operator' => $this->student->operator_id,
                'message' => $this->message,
                'status' => 'failed',
                'response' => $response->getBody()
            ]);
            Cache::increment("sms_progress_{$this->key}_failed");
        }
            

        } catch (\Exception $e) {

            SmsHistory::create([
                'institution_id' => $this->student->institution_id,
                'phone' => $this->student->contactNo,
                'operator' => $this->student->operator_id,
                'message' => $this->message,
                'status' => 'API failed',
                'response' => $e->getMessage()
            ]);

            Cache::increment("sms_progress_{$this->key}_failed");
        }
    }

}
