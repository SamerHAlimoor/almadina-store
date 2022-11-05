@extends('layouts.dashboard')

@section('title', 'Edit Product')

@section('breadcumbs')
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')

<form action="{{ route('dashboard.products.update',  $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    
    @include('dashboard.products._form', [
        'button_label' => 'Update'    
    ])
</form>

@endsection