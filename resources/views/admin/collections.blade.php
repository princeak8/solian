@extends('layouts/admin')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Collections <a href="{{url('admin/collection/create')}}" class="btn btn-sm btn-primary ml-3">Add New Collection</a></h6>
  </div>
  <div class="card-body">
        @if($collections->count() > 0)
          <div id="collections" class="row">
            @foreach($collections as $collection)
              <div class="col-4">
                <img src="{{ asset('uploads/collections/thumbnails/'.$collection->photo) }}" alt="" title="" style="width:100%; height:15em;" />
                <span>{{$collection->name}}</span><br/>
                <a href="{{url('admin/collection/'.$collection->id)}}" class="btn btn-primary">View</a>
                <a href="{{url('admin/collection/edit/'.$collection->id)}}" class="btn btn-warning">Edit</a>
                <a href="{{url('admin/collection/delete/'.$collection->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You want to Delete this collection?')">Delete</a>
              </div>
            @endforeach
          </div>
        @else
          <p>No Collection has been added at this point</p>
        @endif
  </div>
</div>
@stop