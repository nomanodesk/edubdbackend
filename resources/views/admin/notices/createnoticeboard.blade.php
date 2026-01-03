@extends('layouts.adminlayout')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">CREATE SCHOOL NOTICE</h4>
      @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form class="forms-sample" action="{{route('notice_boards.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <textarea class="form-control" id="exampleTextarea1" name="description" rows="10"></textarea>
        </div>
        <input type="hidden" name='institution_id' value="{{Auth::user()->Institution->id}}">
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection