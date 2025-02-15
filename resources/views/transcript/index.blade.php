<!DOCTYPE html>
<html>
<head>
    <title>Transcripts</title>
</head>
<body>
    <h1>Transcripts</h1>
    <form action="{{ route('transcript.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    @foreach ($students as $student)
        <h2>{{ $student->student_name }}</h2>
        <p>{{ $student->student_no }}</p>
        <a href="{{ route('transcript.edit', $student->id) }}">Edit</a>
        <form action="{{ route('transcript.destroy', $student->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>

        <h3>Courses</h3>
        <ul>
            @foreach ($student->courses as $course)
                <li>{{ $course->course_name }} - {{ $course->grade }}</li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>
