@extends('layouts.adminlayout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="progress">
  <div id="bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%"></div>
</div>

<script>
let key = "{{ $key }}";

let timer = setInterval(() => {
    fetch(`/notice-progress-status/${key}`)
        .then(res => res.json())
        .then(data => {
            let percent = ((data.sent + data.failed + data.unregistered) / data.total) * 100;
            document.getElementById('bar').style.width = percent + '%';

            if (data.done) {
                clearInterval(timer);
                Swal.fire({
                    icon: 'success',
                    title: 'SMS Completed',
                    text: `Sent: ${data.sent}, Failed: ${data.failed}, Unregistered: ${data.unregistered}`
                }).then(() => {
                    window.location.href = "{{ route('home') }}";
                });
            }
        });
}, 2000);
</script>

@endsection
