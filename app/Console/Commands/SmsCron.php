<?php

namespace App\Console\Commands;

use App\Appointment;
use App\SendSmsLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SmsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");

        $event  = Appointment::whereDate('start', Carbon::tomorrow())
            ->whereNotNull('number')->get();


        $log = SendSmsLog::whereDate('created_at', Carbon::today())->get();


        // iterate over the array of recipients and send a twilio request for each
        foreach ($event as $recipient) {
            if ($log->contains('appointment_id', $recipient->id)){
                echo "message already sent";
            }else{
                $date = $recipient->start;
                $date = strtotime($date);
                $datum = date('H:i', $date);

                $message = "Beste Klant, Morgen heeft u om ".$datum." uur een afspraak bij Sunaina's Beauty Care. Tot dan! ";

                $this->sendMessage($message, '+'.$recipient->number);

                SendSmsLog::insert(['appointment_id'=>$recipient->id,'number'=>$recipient->number,'status'=>'sent','created_at' => now()]);
            }

        }

        $this->info('Sms:Cron Cummand Run successfully!');
    }

    public function sendMessage($message,$recipients)
    {

        $sid    = env( 'TWILIO_SID' );
        $token  = env( 'TWILIO_TOKEN' );
        $from  = env( 'TWILIO_FROM' );
        $client = new \Twilio\Rest\Client($sid, $token);
        $client->messages->create($recipients,
            ['from' => $from, 'body' => $message] );
    }
}
