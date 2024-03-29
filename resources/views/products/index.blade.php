@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>


<form action="{{ route('products.index') }}" method="GET" class="row g-3">

< class="col-sm-12 col-md-3">
    <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">

@csrf
<form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
    @method('DELETE')
    button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
</form>

    <input type="submit" value="検索">
</form>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">新規登録</a>

    <div class="products mt-5">
        <h2>商品情報</h2>
        <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company->company_name }}</td>
<td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>
                    </td>
                </tr>
        </tr>
    @endforeach
    </tbody>
    </table>
    </div>

</div>