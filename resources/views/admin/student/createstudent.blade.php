@extends('layouts.adminlayout')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ADD STUDENT DATA</h4>
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

      <form class="forms-sample" action="{{route('student_profiles.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Student Name *</label>
          <input type="text" class="form-control" id="exampleInputName1" name='studentName' required>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword4">Contact No.*</label>
          <input type="number" class="form-control" id="exampleInputPassword4" name='contactNo' placeholder="01xxxxxxxxx" required>
        </div>
        <!-- <label for="exampleInputPassword4">operator*</label>
        <div class="col-md-10">
          <div class="form-group row">
            <div class="col-sm-3">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="operator_id" id="membershipRadios1" value="Banglalink" required> Banglalink </label>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="operator_id" id="membershipRadios2" value="Robi"> Robi / Airtel </label>
              </div>
            </div>
          </div>
        </div> -->

        <div class="form-group">
          <label for="exampleTextarea1">Address*</label>
          <textarea class="form-control" id="exampleTextarea1" name="address" rows="4"></textarea>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail3">UID</label>
          <input type="text" class="form-control" id="exampleInputEmail3" name='uid'>
        </div>
        <input type="hidden" name='institution_id' value="{{Auth::user()->Institution->id}}">
        <!-- <div class="form-group">
          <div class="form-group">
            <label>Student Pic</label>
            <div class="input-group col-xs-12">
              <span class="input-group-append">
                <input type="file" id="appLogo" class="form-control" name="studentImage" placeholder="Student Pic here">
              </span>
            </div>
          </div> -->
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection