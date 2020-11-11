<?php

namespace App\Http\Controllers;

use App\Category;
use App\Client;
use App\Currency;
use App\DataTables\ServicePaymentDataTable;
use App\DataTables\ServicesDataTable;
use App\Models\Discount;
use App\Product;
use App\ProductOrder;
use App\Service;
use App\ServiceOrder;
use App\ServicePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ServicePaymentController extends Controller
{
    private $categoryRepository;
    private $serviceRepository;
    private $clientRepository;
    private $productRepository;
    private $currencyRepository;
    private $discountRepository;

    public function __construct(Service $serviceRepo, Category $categoryRepo, Client $clientRepo, Product $productRepo, Currency $currencyRepo, Discount $discountRepo)
    {
        $this->clientRepository = $clientRepo;
        $this->serviceRepository = $serviceRepo;
        $this->categoryRepository = $categoryRepo;
        $this->productRepository = $productRepo;
        $this->currencyRepository = $currencyRepo;
        $this->discountRepository = $discountRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('service_payments')
                ->join('clients', 'clients.id', '=', 'service_payments.client_id')
                ->select('service_payments.*', 'clients.name', 'clients.number')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'service_payments.datatable_actions')
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('service_payments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = array('service' => 'Service','product' =>'Product');
        $client = $this->clientRepository->pluck('name', 'id');
        $service = $this->serviceRepository->pluck('name', 'id');
        $product = $this->productRepository->pluck('name', 'id');
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $serviceprice = $this->serviceRepository->all();
        $productprice = $this->productRepository->all();

        $price_attributes = $serviceprice->mapWithKeys(function ($item) {
            return [$item->id => ['data-priceInfo' => $item->price, 'data-priceCurrency' => $item->currency->currency]];
        })->toArray();

        $product_price_attributes = $productprice->mapWithKeys(function ($item) {
            return [$item->id => ['data-priceProductInfo' => $item->price, 'data-priceProductCurrency' => $item->currency->currency]];
        })->toArray();


        return view('service_payments.create')->with("client", $client)->with('product',$product)->with('service',$service)->with('productprice',$product_price_attributes)->with('serviceprice',$price_attributes)->with('currency',$currency)->with('type',$type);
    }

    public function store(Request $request)
    {
        request()->validate([
            'client_id' => 'required',
        ]);

        $client = $request->input('client_id');

        if(!is_numeric($client)){
            $newClient = new Client;
            $newClient->name = $request->input('client_id');
            $newClient->number = $request->input('txtPhone');
            $newClient->save();

            $request->merge( array( 'client_id' => $newClient->id ) );

        }


        $servicePayment = ServicePayment::create($request->all());
        $lastId = $servicePayment->id;

        $datadiscountinput[] = $request->input('hiddendiscount');
        foreach($datadiscountinput as $value) {
            foreach ($value as $r){
                $var = explode("-",$r);
                if(!empty($var[0])){
                    Discount::create(['type'=> $var[0],'currency_id'=> $var[1],'discount' => $var[2],'service_payment_id' => $lastId]);
                }

            }

        }

        $datainput[] = $request->input('service_id');
        foreach($datainput as $value) {
            foreach ($value as $r){
                $find = Service::find($r);
                if(!empty($find->price)){
                    ServiceOrder::create(['service_id'=> $r,'price' => $find->price,'service_payment_id' => $lastId]);
                }

            }

        }

        $productinput[] = $request->input('product_id');
        foreach($productinput as $value) {
            foreach ($value as $r){
                $find = Product::find($r);
                if(!empty($find->price)) {
                    ProductOrder::create(['product_id' => $r, 'price' => $find->price, 'service_payment_id' => $lastId]);
                }

            }

        }


        return redirect()->route('service-payments.index')
            ->with('success', 'Service Payment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServicePayment  $servicePayment
     * @return \Illuminate\Http\Response
     */
    public function show(ServicePayment $servicePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServicePayment  $servicePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicePayment $servicePayment)
    {
        $type = array('service' => 'Service','product' =>'Product');
        $client = $this->clientRepository->pluck('name', 'id');
        $service = $this->serviceRepository->pluck('name', 'id');
        $product = $this->productRepository->pluck('name', 'id');
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $serviceprice = $this->serviceRepository->all();
        $productprice = $this->productRepository->all();
        $discounts = $this->discountRepository->all();

        $price_attributes = $serviceprice->mapWithKeys(function ($item) {
            return [$item->id => ['data-priceInfo' => $item->price, 'data-priceCurrency' => $item->currency->currency]];
        })->toArray();

        $product_price_attributes = $productprice->mapWithKeys(function ($item) {
            return [$item->id => ['data-priceProductInfo' => $item->price, 'data-priceProductCurrency' => $item->currency->currency]];
        })->toArray();

        return view('service_payments.edit',compact('servicePayment'))
            ->with("client", $client)
            ->with('product',$product)
            ->with('service',$service)
            ->with('productprice',$product_price_attributes)
            ->with('serviceprice',$price_attributes)
            ->with('currency',$currency)
            ->with('type',$type)
            ->with('discounts', $discounts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServicePayment  $servicePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicePayment $servicePayment)
    {
        $servicePayment->delete();
        request()->validate([
            'client_id' => 'required',
        ]);
        $servicePayment = ServicePayment::create($request->all());

        $lastId = $servicePayment->id;

        $datadiscountinput[] = $request->input('hiddendiscount');
        if(!empty($datadiscountinput)){
            foreach($datadiscountinput as $value) {
                foreach ($value as $r){
                    $var = explode("-",$r);
                    if(!empty($var[0])){
                        Discount::create(['type'=> $var[0],'currency_id'=> $var[1],'discount' => $var[2],'service_payment_id' => $lastId]);
                    }

                }

            }
        }


        $datainput[] = $request->input('service_id');
        if(!empty($datainput)){
            foreach($datainput as $value) {
                foreach ($value as $r){
                    $find = Service::find($r);
                    if(!empty($find->price)){
                        ServiceOrder::create(['service_id'=> $r,'price' => $find->price,'service_payment_id' => $lastId]);
                    }

                }

            }
        }


        $productinput[] = $request->input('product_id');
        if(!empty($productinput)){
            foreach($productinput as $value) {
                foreach ($value as $r){
                    $find = Product::find($r);
                    if(!empty($find->price)) {
                        ProductOrder::create(['product_id' => $r, 'price' => $find->price, 'service_payment_id' => $lastId]);
                    }

                }

            }
        }


        return redirect()->route('service-payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServicePayment  $servicePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicePayment $servicePayment)
    {

        $servicePayment->delete();
        return redirect()->route('service-payments.index')
            ->with('success', 'Payment deleted successfully');
    }
}
