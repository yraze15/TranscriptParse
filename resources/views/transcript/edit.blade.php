<!DOCTYPE html>
<html>
<head>
    <title>Edit Transcript</title>
</head>
<body>
    <h1>Edit Transcript</h1>
    <form action="{{ route('transcript.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="student_no">Student No:</label>
        <input type="text" name="student_no" value="{{ $student->student_no }}" required>

        <label for="student_name">Student Name:</label>
        <input type="text" name="student_name" value="{{ $student->student_name }}" required>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" value="{{ $student->gender }}" required>

        <label for="birth_date">Birth Date:</label>
        <input type="date" name="birth_date" value="{{ $student->birth_date }}" required>

        <label for="department">Department:</label>
        <input type="text" name="department" value="{{ $student->department }}" required>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" value="{{ $student->specialization }}">

        <label for="probation">Probation:</label>
        <input type="checkbox" name="probation" {{ $student->probation ? 'checked' : '' }}>

        <h3>Courses</h3>
        @foreach ($student->courses as $course)
            <div>
                <label for="courses[{{ $course->id }}][course_no]">Course No:</label>
                <input type="text" name="courses[{{ $course->id }}][course_no]" value="{{ $course->course_no }}" required>

                <label for="courses[{{ $course->id }}][course_name]">Course Name:</label>
                <input type="text" name="courses[{{ $course->id }}][course_name]" value="{{ $course->course_name }}" required>

                <label for="courses[{{ $course->id }}][credit_hours]">Credit Hours:</label>
                <input type="number" name="courses[{{ $course->id }}][credit_hours]" value="{{ $course->credit_hours }}" required>

                <label for="courses[{{ $course->id }}][grade]">Grade:</label>
                <input type="text" name="courses[{{ $course->id }}][grade]" value="{{ $course->grade }}" required>

                <label for="courses[{{ $course->id }}][points]">Points:</label>
                <input type="number" step="0.1" name="courses[{{ $course->id }}][points]" value="{{ $course->points }}" required>

                <label for="courses[{{ $course->id }}][note]">Note:</label>
                <input type="text" name="courses[{{ $course->id }}][note]" value="{{ $course->note }}">

                <label for="courses[{{ $course->id }}][result]">Result:</label>
                <input type="text" name="courses[{{ $course->id }}][result]" value="{{ $course->result }}" required>
            </div>
        @endforeach

        <button type="submit">Update</button>
    </form>
</body>
</html>
