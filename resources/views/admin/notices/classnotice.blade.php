@extends('layouts.adminlayout')

@section('content')
@foreach($class as $data)
@endforeach
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">
        NOTICE BOARD</h4>
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
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
      <div>
     
      <form class="forms-sample" action="{{route('classStudentNotice')}}" method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group">
          <textarea class="form-control" id="exampleTextarea1" name="notice" rows="10">Dear Students</textarea>
        
          <input type="hidden" name='class_id' value="{{$data->id}}">
          <button type="submit" class="btn btn-gradient-danger me-2">Send SMS Notice</button>
          </div>
      </form>
</div>

    </div>
  </div>
</div>
@endsection