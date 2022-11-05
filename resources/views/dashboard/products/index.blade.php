@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection


@push('css')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

@endpush


@section('content')

<x-alert type="success" />
<x-alert type="info" />

<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>
</form>




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
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
                    <th colspan="2">Operations</th>
                </tr>
                </thead>
                <tbody>
                  @forelse($products as $key=> $product)
                  <tr>
                      <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->category->name }}</td>
                      <td>{{ $product->store->name }}</td>
                      <td>{{ $product->status }}</td>
                      <td>{{ $product->created_at }}</td>
                      <td>
                          <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                      </td>
                      <td>
                          <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                              @csrf
                              <!-- Form Method Spoofing -->
                              <input type="hidden" name="_method" value="delete">
                              @method('delete')
                              <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                          </form>
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="9">No products defined.</td>
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
  </section>




@endsection

@push('js')
<!--<script src=""></script> -->
<script src="{{asset("plugins/datatables/jquery.dataTables.min.js")}}"></script>

<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>


@endpush