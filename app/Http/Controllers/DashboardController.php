<?php

namespace App\Http\Controllers;

use App\Chartpayment;
use App\Client;
use App\ProductOrder;
use App\ServiceOrder;
use App\ServicePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysqli;

class DashboardController extends Controller
{
    public function index(){
       $clients = Client::all()->count();

        $ordersCount = ServicePayment::get()->where('created_at', '>=', Carbon::today())->count();


        $todayrecords = Chartpayment::where('created_at', '>=', Carbon::today())->first();


        $chartpayment = Chartpayment::whereBetween('created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfWeek()])->get();

        $thismonth =  Chartpayment::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $lastmonth =  Chartpayment::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();
        $last3months =  Chartpayment::whereBetween('created_at', [Carbon::now()->subMonth(3)->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();
        return view('dashboard.index',compact('clients','ordersCount','last3months','todayrecords','chartpayment','thismonth','lastmonth'));
    }

    public function upload2server(){
        $status = array();
        //Enter your database information here and the name of the backup file
        $mysqlDatabaseName ='sunaina_care';
        $mysqlUserName ='sunaina_wishaal';
        $mysqlPassword ='FFFsYytnOa+1';
        $mysqlHostName ='localhost';
        $mysqlExportPath ='sunaina_care.sql';

        //Please do not change the following points
        //Export of the database and output of the status
        $command='mysqldump --skip-comments --opt -h ' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
        $output1 = $output = array();
        exec($command, $output1,$worked);
        switch($worked){
            case 0:
                $content = file_get_contents('sunaina_care.sql');
                $content = str_replace('/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */', '', $content);
                file_put_contents('sunaina_care.sql', $content);

                $ftp_server="147.135.10.137";
                $ftp_user_name="sunaina";
                $ftp_user_pass="R!sh!w1993";
                $file = "sunaina_care.sql";//tobe uploaded
                $remote_file = "app.sunainasbeautycare.com/sunaina_care.sql";

                // set up basic connection
                $conn_id = ftp_connect($ftp_server);

                // login with username and password
                $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

                // upload a file
                if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
                    $status[] = ['status' =>'done'];
                } else {
                    $status[] = ['status' =>'ftperror'];
                }
                // close the connection
                ftp_close($conn_id);


                break;
            case 1:
                $status[] = ['status' =>'error'];
                break;
            case 2:
                $status[] = ['status' =>'database'];
                break;
        }

        return response()->json($status);
    }

    public function import2db(){
        $sql = file_get_contents('../sunaina_care.sql');

        $mysqli = new mysqli("localhost", "sunaina_wishaal", "FFFsYytnOa+1", "sunaina_care");

        /* execute multi query */
        $mysqli->multi_query($sql);

        return response()->json(['status' =>'done']);

    }
}
