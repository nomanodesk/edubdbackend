@extends('layouts.adminlayout')

@section('content')
<div class="container mt-4">
    <!-- <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4> <a class="btn btn-gradient-primary btn-sm" href="{{ route('institute_classes.create') }}"> Add New Class</a></h4>
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
    @if(session('popup_error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops!',
    text: "{{ session('popup_error') }}",
    confirmButtonText: 'OK'
});
</script>
@endif
    <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Class List</h4>
                    <a class="btn btn-gradient-primary btn-sm" href="{{ route('institute_classes.create') }}"> Add New Class</a>
                    
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm" id="dataTables-example1">
                            <thead>
                                <tr> <th>#</th>
                                    <th> Name </th>
                                    <th> Level </th>
                                    
                                    <th> Action </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($instituteclasses as $applinkapp)
                                <tr>
                                <td>{{ ++$i }}</td>
                                    <td>{{ $applinkapp->className }}</td>
                                    <td>{{ $applinkapp->class_level }}</td>
                                  <td>

                                  <div class="btn-group" role="group" aria-label="Basic example">
                                  <a class="btn btn-gradient-dark btn-rounded btn-fw btn-sm" href="{{route('institute_classes.edit',$applinkapp->id)}}">Edit Class</a>
                                  <a class="btn btn-gradient-success btn-rounded btn-fw btn-sm" href="{{route('getClassStudents',$applinkapp->id)}}">Manage Students</a>
                                  <a class="btn btn-gradient-danger btn-rounded btn-fw btn-sm" href="{{route('getsection',$applinkapp->id)}}">Manage Sections</a>
                                  <a class="btn btn-gradient-info btn-rounded btn-fw btn-sm" href="{{route('classnoticepage',$applinkapp->id)}}">Send Class Notice</a>
                                        </div>
                                  </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $instituteclasses->links() !!}
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