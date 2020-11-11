<?php

namespace App\Http\Controllers;

use App\Category;
use App\Currency;
use App\DataTables\ServicesDataTable;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $categoryRepository;
    private $serviceRepository;

    public function __construct(Service $serviceRepo, Category $categoryRepo,Currency $currencyRepo)
    {
        $this->serviceRepository = $serviceRepo;
        $this->categoryRepository = $categoryRepo;
        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServicesDataTable $dataTable)
    {
        return $dataTable->render('services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $category = $this->categoryRepository->pluck('name', 'id');
        return view('services.create')->with("category", $category)->with("currency", $currency);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'price' => 'required',
            'duration' => 'required',
            'category_id' => 'required',
            'name' => 'required',
        ]);
        Service::create($request->all());
        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $category = $this->categoryRepository->pluck('name', 'id');
        return view('services.show', compact('service'))->with("category",$category)->with("currency", $currency);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $category = $this->categoryRepository->pluck('name', 'id');
        return view('services.edit',compact('service'))->with("category", $category)->with("currency", $currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        request()->validate([
            'price' => 'required',
            'duration' => 'required',
            'category_id' => 'required',
            'name' => 'required',
        ]);
        $service->update($request->all());
        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
            ->with('success', 'Services deleted successfully');
    }
}
