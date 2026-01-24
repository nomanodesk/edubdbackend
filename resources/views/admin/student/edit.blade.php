@extends('layouts.adminlayout')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Student</h4>

        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Student Name -->
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="studentName"
                       class="form-control"
                       value="{{ old('studentName', $student->studentName) }}" required>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address"
                       class="form-control"
                       value="{{ old('address', $student->address) }}" required>
            </div>

            <!-- Contact -->
            <div class="mb-3">
                <label>Contact No</label>
                <input type="text" name="contactNo"
                       class="form-control"
                       value="{{ old('contactNo', $student->contactNo) }}" required>
            </div>

            <!-- Class -->
            <div class="mb-3">
                <label>Class</label>
                <select name="institue_class_id" id="class_id" class="form-select" required>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ $student->schoolData->institue_class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->className }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Section -->
            <div class="mb-3">
                <label>Section</label>
                <select name="class_section_id" id="section_id" class="form-select" required>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}"
                            {{ $student->schoolData->class_section_id == $section->id ? 'selected' : '' }}>
                            {{ $section->sectionName }} ({{ $section->class_shift }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Update Student</button>
            <a href="{{ route('student_profiles.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
