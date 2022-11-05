@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcumbs')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">{{  $category->name }}</li>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        
        @php
            $products = $category->products()->with('store')->latest()->paginate(10);
        @endphp
        @forelse($products as $key=> $product)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No products defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center  mt-5 ">
    {{ $products->withQueryString()->appends(['search' => 1])->links() }}

  </div>
</div>
<!-- /.card-body -->
</div>

<!-- /.card -->


<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->

@endsection