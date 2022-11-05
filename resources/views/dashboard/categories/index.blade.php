@extends('layouts.dashboard')

@section('title', 'Categories')



@section('breadcumbs')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Products Count</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th colspan="2">Operations</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @forelse($categories as $key=> $category)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a></td>
                        <td>{{ $category->parent->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->status }}</td>
                        <td>
@if ($category->image != null)
<img src="{{asset('storage/'.$category->image)}}" alt="" width="50px" height="50px">
@else
<img src="{{asset('storage/categories/'.'no_image.png')}}" alt="" width="50px" height="50px">
  
@endif

                        </td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            
                            <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                            
                        </td>
                        <td>
                           
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
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
                        <td colspan="9" class="center">No categories defined.</td>
                    </tr>
                    @endforelse
                </tr>
               
               
                
                </tbody>
              </table>

              <div class="d-flex justify-content-center  mt-5 ">
                {{ $categories->withQueryString()->appends(['search' => 1])->links() }}

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

