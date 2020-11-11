<?php

namespace App\Http\Controllers;
use App\DataTables\CurrencyDataTable;
use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:currency-list|currency-create|currency-edit|currency-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:currency-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:currency-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:currency-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyDataTable $dataTable)
    {
        return $dataTable->render('currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'currency' => 'required',
        ]);
        Currency::create($request->all());
        return redirect()->route('currencies.index')
            ->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return view('currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        request()->validate([
            'currency' => 'required',
        ]);
        $currency->update($request->all());
        return redirect()->route('currencies.index')
            ->with('success', 'Currency updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Currency $currency
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')
            ->with('success', 'Currency deleted successfully');
    }
}
