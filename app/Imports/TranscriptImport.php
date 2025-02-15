<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TranscriptImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        static $student = null;

        if ($row[0] && strpos($row[0], 'Student No') !== false) {
            $student = Student::create([
                'student_no' => $row[1],
                'department' => $row[3],
                'student_name' => $row[4],
                #'gender' => $row[3],
                #'birth_date' => $row[7],
                #'specialization' => $row[11],
                #'probation' => $row[13] ?? false,
            ]);
        }

        if ($row[0] && is_numeric($row[0])) {
            return new Course([
                'student_id' => $student->id,
                'academic_year' => $row[0],
                'semester' => $row[1],
                'course_no' => $row[2],
                'course_name' => $row[3],
                'credit_hours' => $row[4],
                'grade' => $row[5],
                'points' => $row[6],
                'note' => $row[7],
                'result' => $row[8],
            ]);
        }

        return null;
    }
}
