<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TranscriptImport;

class TranscriptController extends Controller
{
    public function index()
    {
        $students = Student::with('courses')->get();
        return view('transcript.index', compact('students'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new TranscriptImport, $request->file('file'));

        return redirect()->route('transcript.index')->with('success', 'Transcript uploaded successfully.');
    }

    public function edit($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        return view('transcript.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->only(['student_no', 'student_name', 'gender', 'birth_date', 'department', 'specialization', 'probation']));

        foreach ($request->courses as $courseData) {
            $course = Course::findOrFail($courseData['id']);
            $course->update($courseData);
        }

        return redirect()->route('transcript.index')->with('success', 'Transcript updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('transcript.index')->with('success', 'Transcript deleted successfully.');
    }
}
