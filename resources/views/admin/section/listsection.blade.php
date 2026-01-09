@extends('layouts.adminlayout')

@section('content')
@foreach ($classinfo as $data)
@endforeach
<div class="container mt-4">
    <div class="row">
        <!-- <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <form action="{{route('addsection')}}" method="POST">
                    @csrf
                    <input type="hidden" name="institue_class_id" value="{{$data->id}}">
                    <button class="btn btn-gradient-primary btn-sm">Add Section</button>
                </form>
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
                        <h4 class="card-title">Section List For Class - {{$data->className}} </h4>
                        <form action="{{route('addsection')}}" method="POST">
                    @csrf
                    <input type="hidden" name="institue_class_id" value="{{$data->id}}">
                    <button class="btn btn-gradient-primary btn-sm">Add Section</button>
                </form>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dataTables-example1">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th> Name </th>
                                        <th> Shift </th>
                                        <th> Version</th>
                                        <th> Action </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classsections as $applinkapp)
                                    <tr>
                                    <td>{{ ++$i }}</td>
                                        <td>{{ $applinkapp->sectionName }}</td>
                                        <td>{{ $applinkapp->class_shift }}</td>
                                        <td>{{ $applinkapp->class_version }}</td>


                                        <td>
                                            <div class="template-demo">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class="btn btn-gradient-dark btn-rounded btn-fw btn-sm" href="{{route('institute_classes.edit',$applinkapp->id)}}">Edit </a>
                                                    <a class="btn btn-gradient-dark btn-rounded btn-fw btn-sm" href="{{route('student_school_data.index',$applinkapp->id)}}">View Students </a>


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