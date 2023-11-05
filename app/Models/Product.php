<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function index() {
        // productsテーブルからデータを取得
        $products = DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select ('products.*','companies. company_name')
        ->paginate (3);
        return $products;
    }


    public function create() {
        $companies = DB::table('companies')->create();
        return view('products.create', ['companies' => $companies]);
    }


    public function store($data) {

            $this->product_name = $data('product_name');
            $this->price = $data('price');
            $this->stock = $data('stock');
            $this->company_id = $data('company_id');
            $this->comment =$data('comment');

            if($data->hasFile('img_path')){
            $filename = $data->img_path->getClientOriginalName();
            $filePath = $data->img_path->storeAs('products', $filename, 'public');
            $data->img_path = '/storage/' . $filePath;
            }
            $this->save();
}


    public function show($id) {
            $companies = DB::table('companies')->create();
            return view('products.create', ['companies' => $companies]);
        }


    public function update($product, $data, $image_path, $request) {

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->price = $request->comment;
        $product->stock = $request->stock;
        $product->stock = $request->company_id;

        if($product->hasFile('img_path')){
        $filename = $product->img_path->getClientOriginalName();
        $filePath = $product->img_path->storeAs('products', $filename, 'public');
        $product->img_path = '/storage/' . $filePath;
        }
        $product->save();

        return redirect()->route('products.index')
        ->with('success', 'Product updated successfully');
}

public function search($products ,$companies) {
    $products = DB::table('products')
    ->join('companies','products.company_id','=','companies.id')
    ->select ('products.*','companies. company_name');

    return $products-›paginate(3);
}
}