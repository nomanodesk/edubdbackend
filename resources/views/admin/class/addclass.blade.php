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

      <form class="forms-sample" action="{{route('institute_classes.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="exampleFormControlSelect2">Select Class Name</label>
          <select name="className" class="form-control" id="exampleFormControlSelect2">
            <option value='I'>I</option>
            <option value='II'>II</option>
            <option value='III'>III</option>
            <option value='IV'>IV</option>
            <option value='V'>V</option>
            <option value='VI'>VI</option>
            <option value='VII'>VII</option>
            <option value='VIII'>VIII</option>
            <option value='IX'>IX</option>
            <option value='X'>X</option>
            <option value='XI'>XI</option>
            <option value='XII'>XII</option>
          </select>
        </div>
        <label for="exampleInputEmail3">Select Class Level</label>

     
        <div class="col-md-6">
                          <div class="form-group row">
                            
                            <div class="col-sm-3">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="class_level" id="membershipRadios1" value="Primary"> Primary </label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="class_level" id="membershipRadios2" value="Secondary"> Secondary </label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="class_level" id="membershipRadios3" value="HSecondary">Higher Secondary </label>
                              </div>
                            </div>
                          </div>
                        </div>
        <input type="hidden" name='institution_id' value="{{Auth::user()->Institution->id}}">
        <div class="form-group">
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <!-- <button class="btn btn-light">Cancel</button> -->
      </form>
    </div>
  </div>
</div>
@endsection