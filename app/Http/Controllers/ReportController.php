<?php

namespace App\Http\Controllers;

use App\Chartpayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(Request $request)
    {


        return view('reports.totaloverview.index');
    }

    public function totaloverview(Request $request)
    {

        $chartpayment = Chartpayment::whereBetween('created_at', [$request->startdate." 00:00:00", $request->enddate." 23:59:59"])->get();


        return view('reports.totaloverview.index',compact('chartpayment','request'));
    }
}
