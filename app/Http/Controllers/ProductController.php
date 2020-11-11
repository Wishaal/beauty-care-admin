<?php

namespace App\Http\Controllers;

use App\Currency;
use App\DataTables\ProductsDataTable;
use App\Product;
use App\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $typeRepository;
    private $productRepository;

    public function __construct(Product $productRep, Type $typeRepo, Currency $currencyRepo)
    {
        $this->productRepository = $productRep;
        $this->typeRepository = $typeRepo;
        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = $this->typeRepository->pluck('name', 'id');
        $currency = $this->currencyRepository->pluck('currency', 'id');
        return view('products.create')->with("type", $type)->with("currency", $currency);

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
            'type_id' => 'required',
            'name' => 'required',
        ]);
        Product::create($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $type = $this->typeRepository->pluck('name', 'id');
        return view('products.show', compact('product'))->with("type",$type)->with("currency", $currency);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $currency = $this->currencyRepository->pluck('currency', 'id');
        $type = $this->typeRepository->pluck('name', 'id');
        return view('products.edit',compact('product'))->with("type", $type)->with("currency", $currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        request()->validate([
            'price' => 'required',
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
