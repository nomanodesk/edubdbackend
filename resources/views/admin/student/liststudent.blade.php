@extends('layouts.adminlayout')

@section('content')
<div class="container mt-4">
    <!-- <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4> <a class="btn btn-gradient-primary btn-sm" href="{{ route('student_profiles.create') }}"> Add New Student</a></h4>
            </div>

        </div>
    </div> -->
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if(session('excelErrors'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Import Failed',
    html: `
        <ul style="text-align:left">
        @foreach(session('excelErrors') as $error)
            <li>Row {{ $error->row() }}: {{ implode(', ', $error->errors()) }}</li>
        @endforeach
        </ul>
    `
});
</script>
@endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Student List</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered ">
                            <tr><td>
                  <a class="btn btn-gradient-primary btn-sm" href="{{ route('student_profiles.create') }}"> Add New Student</a></td>
                   <td></tr>
                    </table>
                    </div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('failures'))
<div class="alert alert-danger">
    <ul>
        @foreach(session('failures') as $f)
        <li>Row {{ $f->row() }}: {{ implode(', ', $f->errors()) }}</li>
        @endforeach
    </ul>
</div>
@endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered " id="dataTables-example1">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th> Name </th>
                                    <th> Address </th>
                                    <th> Contact</th>
                                    <th> UID</th>
                                    <th> Menu </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $applinkapp)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    @if($applinkapp->studentImage !=NULL)
                                    <td><img src="studentImages/{{ $applinkapp->studentImage }}" height="50" width="50px"> {{ $applinkapp->studentName }}</td>
                                    @else
                                    <td><img src="admin/images/faces-clipart/pic-1.png" height="50" width="50px"> {{ $applinkapp->studentName }}</td>
                                    @endif
                                    <td>{{ $applinkapp->address }}</td>
                                    <td>{{ $applinkapp->contactNo }}</td>
                                    @if($applinkapp->uid !=NULL)
                                    <td>{{ $applinkapp->uid }}</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-gradient-dark btn-rounded btn-fw btn-sm" href="{{route('student_profiles.edit',$applinkapp->id)}}">Profile Data</a>
                                            <a class="btn btn-gradient-danger btn-rounded btn-fw btn-sm" href="{{route('student_school_data.edit',$applinkapp->id)}}">Class Data</a>
                                            <a class="btn btn-gradient-info btn-rounded btn-fw btn-sm" href="{{route('noticepage',$applinkapp->id)}}">Send Notice</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $students->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <script>
        function getId(id) {
            // var id =  $(this).attr('id');
            $.ajax({
                url: "/get-base/" + id,
                method: "GET",
                success: function(data) {
                    alert(data);
                }
            });
            //  console.log(id) //displays 2
        }
    </script>