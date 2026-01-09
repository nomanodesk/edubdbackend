

@extends('layouts.adminlayout')

@section('content')

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ADD CLASS DATA</h4>
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

      <form class="forms-sample" action="{{route('addstudentclass')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('admin/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Name: <?php echo $insertedData['studentName'];?> 
                    </h4>
                    <h4 class="font-weight-normal mb-3">Cell: <?php echo $insertedData['contactNo'];?> 
                    </h4>
                    <h4 class="font-weight-normal mb-3">Address: <?php echo $insertedData['address'];?> 
                    </h4>
                    <h4 class="font-weight-normal mb-3">Student ID: <?php echo $insertedData['uid'];?> 
                    </h4>
                    <!-- <h2 class="mb-5">45,6334</h2>
                    <h6 class="card-text">Decreased by 10%</h6> -->
                  </div>
                </div>
              </div>
        <div class="form-group">
          <!-- <label for="exampleInputName1">Student Name *</label> -->
          <input type="hidden" class="form-control" id="exampleInputName1" name='studentName' value="{{$insertedData['studentName']}}" >
        </div>
        <div class="form-group">
          <!-- <label for="exampleInputPassword4">Contact No.*</label> -->
          <input type="hidden" class="form-control" id="exampleInputPassword4" name='contactNo' value="{{$insertedData['contactNo']}}" >
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
        <!-- <div class="form-group">
         
          <textarea class="form-control" id="exampleTextarea1" name="address" rows="4" ><?php echo $insertedData['address'];?></textarea>
        </div> -->
        <div class="form-group">
          <!-- <label for="exampleInputEmail3">UID</label> -->
          <input type="hidden" class="form-control" id="exampleInputEmail3" name='uid' value="{{$insertedData['uid']}}">
          <input type="hidden" class="form-control" id="exampleInputEmail3" name='address' value="{{$insertedData['address']}}">
        
        </div>
        <input type="hidden" name='institution_id' value="{{Auth::user()->Institution->id}}">
       
        <div class="form-group">
          <div class="form-group">
            <label>Student Pic</label>
            <div class="input-group col-xs-12">
              <span class="input-group-append">
                <input type="file" id="appLogo" class="form-control" name="studentImage" placeholder="Student Pic here">
              </span>
            </div>
          </div>
          <label>Class*</label>
          <div class="input-group col-xs-12">
                            <select  name="class_section_id"  class="custom-select" id="class_section_id" required>
                            <option>Select Class</option>
                            @foreach($classes as $data)
                            <option value="{{ $data->id }}" >Class: {{ $data->className }} Section: {{ $data->sectionName }} Shift: {{ $data->class_shift }}</option>
                            @endforeach
                            </select>
           </div>
           <input type="hidden" name="institue_class_id" value="{{$data->institue_class_id}}">
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection