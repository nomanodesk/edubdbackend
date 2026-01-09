@extends('layouts.registerlayout')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ADD INSTITUTE DATA</h4>
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

      <form class="forms-sample" action="{{route('institutions.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Institue Name</label>
          <input type="text" class="form-control" id="exampleInputName1" name='instituteName' required>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Short Name</label>
          <input type="text" class="form-control" id="exampleInputName1" name='nameCode' required>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail3">EIIN</label>
          <input type="text" class="form-control" id="exampleInputEmail3" name='EIIN' required>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword4">Contact No.</label>
          <input type="number" class="form-control" id="exampleInputPassword4" name='contactNo' required>
        </div>
        <input type="hidden" name='user_id' value="{{Auth::user()->id}}">
        <div class="form-group">

          <div class="form-group">
            <label>Logo upload</label>

            <div class="input-group col-xs-12">

              <span class="input-group-append">
                <input type="file" id="appLogo" class="form-control" name="logo" placeholder="Your App Logo here">
              </span>
            </div>
          </div>

          <div class="form-group">
            <label for="exampleTextarea1">Address</label>
            <textarea class="form-control" id="exampleTextarea1" name="address" rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection