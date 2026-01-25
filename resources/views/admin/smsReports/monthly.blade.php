@extends('layouts.adminlayout')

@section('content')

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
     

        <h4 class="card-title">📊 Monthly SMS Report</h4>
        
        {{-- Month Filter --}}
        <form method="GET" action="{{ route('sms.report.monthly') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="month" name="month"
                           class="form-control"
                           value="{{ $month }}" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
       

        {{-- Summary --}}
        <div class="row mb-3">
            <div class="col-md-2">
                <div class="alert alert-info">Total: {{ $summary['total'] }}</div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-success">Sent: {{ $summary['sent'] }}</div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-danger">Failed: {{ $summary['failed'] }}</div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-warning">Unregistered: {{ $summary['unregistered'] }}</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Sent At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $sms)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sms->phone }}</td>
                            <td>{{ Str::limit($sms->message, 50) }}</td>
                            <td>
                                <span class="badge 
                                    {{ $sms->status === 'sent' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($sms->status) }}
                                </span>
                            </td>
                            <td>{{ $sms->created_at->format('d M Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No SMS found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $reports->links() }}

    </div>
</div>

@endsection


<script>
const ctx = document.getElementById('smsChart');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Sent', 'Failed', 'Unregistered'],
        datasets: [{
            data: [{{ $summary['sent'] }}, {{ $summary['failed'] }} {{ $summary['unregistered'] }}],
            backgroundColor: ['#28a745', '#dc3545']
        }]
    }
});
</script>

