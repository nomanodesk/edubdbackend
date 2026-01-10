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
      <div id="smsProgressBox" style="display:none;" class="mb-3">
    <label>Sending SMS, please wait...</label>
    <div style="width:100%; background:#ddd; border-radius:5px; overflow:hidden;">
        <div id="smsProgressBar"
             style="width:0%; height:20px; background:#28a745; transition:width 0.3s;">
        </div>
    </div>
</div>

      <form id="smsForm" class="forms-sample" action="{{route('sendGenNotice')}}" method="POST" enctype="multipart/form-data">
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
<script>
document.getElementById('smsForm').addEventListener('submit', function(e){
    e.preventDefault(); // stop normal submit

    let form = this;
    let progressBox = document.getElementById('smsProgressBox');
    let bar = document.getElementById('smsProgressBar');
    let btn = document.getElementById('sendBtn');

    progressBox.style.display = 'block';
    btn.disabled = true;

    // fake progress animation
    let width = 0;
    let progressTimer = setInterval(() => {
        if (width < 90) {
            width += 5;
            bar.style.width = width + '%';
        }
    }, 300);

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.text())
    .then(() => {
        clearInterval(progressTimer);
        bar.style.width = '100%';

        setTimeout(() => {
            window.location.href = "{{ route('institute_classes.index') }}";
        }, 800);
    })
    .catch(() => {
        clearInterval(progressTimer);
        alert('SMS sending failed!');
        btn.disabled = false;
    });
});
</script>