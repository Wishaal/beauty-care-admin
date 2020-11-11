<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Client;
use App\SendSmsLog;
use App\ServicePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect,Response;
use Illuminate\Support\Facades\App;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {

            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

            $data = Appointment::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','color','start', 'end']);
            return Response::json($data);
        }
        return view('appointments.index');

    }

    public function show(Request $request)
    {
        $where = array('id' => $request->id);
        $event  = Appointment::where($where)->get();

        return Response::json($event);
    }

    public function getClients(Request $request)
    {
        $where = array('id' => $request->id);
        $event = Client::get(['id','name','number']);

        return Response::json($event);
    }

    public function create(Request $request)
    {
        $clientid = $request->client;
        if ( strval($clientid) !== strval(intval($clientid)) ) {
            $client = Client::create(['name' => $request->client,'number' => $request->number]);
            $clientid = $client->id;
        }

        $insertArr = [ 'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'client_id' => $clientid,
            'number' => $request->number,
            'color' => sprintf('#%06X', mt_rand(0xFF9999, 0xFFFF90))
        ];
        $event = Appointment::insert($insertArr);
        return Response::json($event);
    }


    public function update(Request $request)
    {
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Appointment::where($where)->update($updateArr);

        return Response::json($event);
    }

    public function store(Request $request)
    {
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title];
        $event  = Appointment::where($where)->update($updateArr);

        return Response::json($event);
    }


    public function destroy(Request $request)
    {
        $event = Appointment::where('id',$request->id)->delete();

        return Response::json($event);
    }

}
