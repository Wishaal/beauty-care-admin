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

        $db = config('backup.db');
        $exportPath = storage_path('app/' . config('backup.dump_file'));

        // The password is handed to mysqldump through the environment rather than
        // the command line: argv is world-readable via `ps` on a shared host.
        $command = sprintf(
            'mysqldump --skip-comments --opt -h %s -u %s %s > %s',
            escapeshellarg($db['host']),
            escapeshellarg($db['username']),
            escapeshellarg($db['database']),
            escapeshellarg($exportPath)
        );

        $descriptors = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
        $process = proc_open(
            $command,
            $descriptors,
            $pipes,
            null,
            ['MYSQL_PWD' => (string) $db['password']] + $_ENV
        );

        if (!is_resource($process)) {
            return response()->json([['status' => 'error']]);
        }

        foreach ($pipes as $pipe) {
            stream_get_contents($pipe);
            fclose($pipe);
        }
        $worked = proc_close($process);

        switch($worked){
            case 0:
                $content = file_get_contents($exportPath);
                $content = str_replace('/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */', '', $content);
                file_put_contents($exportPath, $content);

                $ftp = config('backup.ftp');

                if (empty($ftp['host'])) {
                    // Offsite upload not configured — the local dump still succeeded.
                    $status[] = ['status' =>'done'];
                    break;
                }

                // FTPS by default: plain FTP sends the password in clear text.
                $conn_id = $ftp['ssl']
                    ? ftp_ssl_connect($ftp['host'], 21, $ftp['timeout'])
                    : ftp_connect($ftp['host'], 21, $ftp['timeout']);

                if ($conn_id === false || !ftp_login($conn_id, $ftp['username'], $ftp['password'])) {
                    $status[] = ['status' =>'ftperror'];
                    break;
                }

                ftp_pasv($conn_id, true);

                if (ftp_put($conn_id, $ftp['remote_path'], $exportPath, FTP_BINARY)) {
                    $status[] = ['status' =>'done'];
                } else {
                    $status[] = ['status' =>'ftperror'];
                }

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
        $dumpPath = storage_path('app/' . config('backup.dump_file'));

        if (!is_readable($dumpPath)) {
            return response()->json(['status' =>'error'], 404);
        }

        $sql = file_get_contents($dumpPath);

        $db = config('backup.db');
        $mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']);

        if ($mysqli->connect_errno) {
            return response()->json(['status' =>'database'], 500);
        }

        /* execute multi query */
        $mysqli->multi_query($sql);
        $mysqli->close();

        return response()->json(['status' =>'done']);

    }
}
