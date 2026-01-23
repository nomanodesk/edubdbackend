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
                    <h4 class="card-title">Upload Student Data</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered ">  
                           <tr>         
                           <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                 @csrf
                <div class="row">
            
  
    <!-- Class -->
    <div class="col-md-12">
        <select name="institue_class_id" id="class_id" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
            <option value="">Select Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">
                    {{ $class->className }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Section -->
                <div class="col-md-12">
                    <select name="class_section_id" id="section_id" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                        <option value="">Select Section</option>
                    </select>
                    <input class="form-control form-control-sm" type="file" name="file" accept=".xlsx,.xls" required>
                </div>
            </div>

             
            <div class="col-md-12">
              <button class="btn btn-gradient-dark btn-sm">Upload Students Data</button>
                    <a href="{{ route('students.template') }}" class="btn btn-gradient-danger btn-sm">Download Excel Template</a>
                    <a class="btn btn-gradient-primary btn-sm" href="{{ route('student_profiles.create') }}"> Add New Student</a></td>
                <!-- Button -->
             </div>
                     </form>
                </tr>
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
   <div class="card-body">
    <h4 class="card-title">Students List</h4>
        <form method="GET" action="{{ route('students.index') }}">
            <div class="row">
              
            <!-- Class -->
                <div class="col-md-3">
                    <select name="institue_class_id" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('institue_class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->className }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Section -->
                <div class="col-md-3">
                    <select name="class_section_id" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option value="">Select Section</option>
                        @foreach(\App\Models\ClassSection::all() as $section)
                            <option value="{{ $section->id }}"
                                {{ request('class_section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->sectionName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Shift -->
                <div class="col-md-3">
                    <select name="class_shift" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option value="">Select Shift</option>
                        <option value="Morning" {{ request('class_shift') == 'Morning' ? 'selected' : '' }}>Morning</option>
                        <option value="Day" {{ request('class_shift') == 'Day' ? 'selected' : '' }}>Day</option>
                    </select>
                </div>

                <!-- Button -->
                <div class="col-md-3">
                    <button class="btn btn-gradient-success btn-sm">
                        Search Students
                    </button>
                </div>
            </div>
</form>


<!-- STUDENT LIST -->


        @if($students->isEmpty())
            <div class="alert alert-warning">
                No students found
            </div>
        @else
        <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dataTables-example1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Shift</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->studentName }}</td>
                            <td>{{ $student->contactNo }}</td>
                            <td>{{ $student->className }}</td>
                            <td>{{ $student->sectionName }}</td>
                            <td>{{ $student->class_shift }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>
        @endif

    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('class_id').addEventListener('change', function () {

        let classId = this.value;
        let sectionDropdown = document.getElementById('section_id');

        sectionDropdown.innerHTML = '<option value="">Loading...</option>';

        if (!classId) {
            sectionDropdown.innerHTML = '<option value="">Select Section</option>';
            return;
        }

        fetch("{{ url('/get-sections') }}/" + classId)
            .then(res => res.json())
            .then(data => {

                sectionDropdown.innerHTML = '<option value="">Select Section</option>';

                if (data.length === 0) {
                    sectionDropdown.innerHTML += '<option value="">No section found</option>';
                    return;
                }

                data.forEach(section => {
                    sectionDropdown.innerHTML += `
                        <option value="${section.id}">
                            ${section.sectionName} (${section.class_shift})
                        </option>
                    `;
                });
            })
            .catch(err => {
                console.error(err);
                sectionDropdown.innerHTML = '<option value="">Error loading sections</option>';
            });
    });

});
</script>


