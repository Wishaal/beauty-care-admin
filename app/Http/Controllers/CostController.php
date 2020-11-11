<?php

namespace App\Http\Controllers;

use App\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Yajra\DataTables\DataTables;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('costs')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'costs.datatable_actions')
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('costs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('costs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $inputData)
    {

        request()->validate([
            'description.*' => 'required|min:1',
            'price.*' => 'required|min:0',
        ]);

        for($i=0; $i<count($inputData['description']); $i++) {
            $data['description'] = $inputData['description'][$i];
            $data['price'] = $inputData['price'][$i];
            $saveData = new Cost($data);
            $saveData->save();
        }
        //Cost::create($request->all());
        return redirect()->route('costs.index')
            ->with('success', 'Cost created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        return view('costs.show', compact('cost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Cost $cost)
    {
        return view('costs.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cost $cost)
    {
        request()->validate([
            'description' => 'required',
            'price' => 'required',
        ]);
        $cost->update($request->all());
        return redirect()->route('costs.index')
            ->with('success', 'Cost updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cost $cost)
    {
        $cost->delete();
        return redirect()->route('costs.index')
            ->with('success', 'Cost deleted successfully');
    }
}
