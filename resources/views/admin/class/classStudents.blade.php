@extends('layouts.adminlayout')

@section('content')
@foreach($class_students as $data)
@endforeach
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
    <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Student List</h4>
                    <a class="btn btn-gradient-primary btn-sm" href="{{route('noticepage',$data->institue_class_id)}}"> Send Class Notice</a>
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm" id="dataTables-example1">
                            <thead>
                                <tr> <th>#</th>
                                    <th> Name </th>
                                    <th> Address </th>
                                    <th> Contact </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($class_students as $applinkapp)
                                <tr>
                                <td>{{ ++$i }}</td>
                                    <td>{{ $applinkapp->studentName }}</td>
                                    <td>{{ $applinkapp->address }}</td>
                                    <td>{{ $applinkapp->contactNo }}</td>     
                                    <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-gradient-dark btn-rounded btn-fw btn-sm" href="{{route('noticepage',$applinkapp->student_id)}}">Send Notice</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      
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