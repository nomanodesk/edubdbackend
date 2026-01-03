@extends('layouts.adminlayout')

@section('content')
@foreach($noticeboard as $data)
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
     
      <form class="forms-sample" action="{{route('sendGenNotice')}}" method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group">
          <textarea class="form-control" id="exampleTextarea1" name="description" rows="10" readonly>{{$data->description}}</textarea>
        
    
          <button type="submit" class="btn btn-gradient-danger me-2">Send SMS Notice</button>
          </div>
      </form>
</div>
<div>
<h4 class="card-title">
        NEW NOTICE</h4>
      <form class="forms-sample" action="{{route('notice_boards.update',$data->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
          <textarea class="form-control" id="exampleTextarea1" name="description" rows="10"></textarea>
          <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
        
          </div>
      </form>
</div>
    </div>
  </div>
</div>
@endsection