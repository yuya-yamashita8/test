<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductsRequest;

class ProductController extends Controller
{
    public function index()
    {
            $products = new Product();
            $companies = new Company();
            $products = $products->index();
            $companies = $companies->index();
            return view('products.index',['products' => $products, 'companies' => $companies]);
    }


    public function create()
    {
        $companies = new Company();
        $companies = $companies->index();
        return view('products.create', ['companies' => $companies]);
    }


    public function store(ProductsRequest $request)
    {
        $data = $request -> all();
        $product = new Product();
        $product->store($data);

        DB::beginTransaction();

    try {
        // 登録処理呼び出し
        $$product_model = new Product();
        $$product_model->store($request);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return back();
    }
    return redirect(route('products.create'));
}

    public function show($id)
    {
        $product_model = new Product();
        $product = $product_model->detail($id);
        return view('products.show', ['product' => $product]);
    }


    public function edit($id)
    {
        $product_model = new Product();
        $company_model = new Company();
        $product = $product_model->detail($id);
        $companies = $company_model->index();
        //商品編集画面を表示する。その際、商品の情報と会社の情報を画面に渡す。
        return view('products.edit', ['product' => $product, 'companies' => $companies]);
    }


    public function update(ProductsRequest $request, $product)
    {
        $data = $request->all();
        $image_path = $request-›file('image_path');
        DB:: beginTransaction();

        try {
            // 登録処理呼び出し
            $product_model = new Product();
            $product_model->update($product, $data, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }


    public function destroy($id)
    {
        // トランザクション開始
        DB::beginTransaction();

        try {
            // 登録処理呼び出し
            $product_model = new Product();
            $product_model->detail($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        // 処理が完了したらproductsにリダイレクト
        return redirect('products.index');
    }


    public function search(ProductsRequest $request)
    {
        $product = $request->input ('search');
        $company = $request->input ('company_name');

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 登録処理呼び出し
            $product_model = new Product();
            $company_model = new Company();
            $product = $product_model->search($product, $company, $request);
            $companies = $company_model->index();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        // 処理が完了したらproductsにリダイレクト
        return view('products.edit', ['product' => $product, 'companies' => $companies]);
    }

}