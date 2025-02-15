<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;

class TranscriptImport implements ToCollection, WithStartRow
{
    private $student = null; // To store the current student
    private $currentAcademicYear = null; // To store the current academic year
    private $currentSemester = null; // To store the current semester

    public function startRow(): int
    {
        return 5; // Start parsing from row 5 (where the student info begins)
    }

    public function collection(Collection $rows)
    {
        // Log all rows for debugging
        Log::info('All rows:', $rows->toArray());

        // Extract student information from specific cells
        $this->student = Student::create([
            'student_no' => $rows[0][1], // B5 (Student No)
            'student_name' => $rows[1][1], // B6 (Student Name)
            'gender' => $rows[2][1], // B7 (Gender)
            'probation' => $rows[3][1] ?? null, // B8 (Probation)
            'department' => $rows[0][3], // D5 (Department)
            'specialization' => $rows[1][3] ?? null, // D6 (Specialization)
        ]);

        // Log student information for debugging
        Log::info('Student created:', $this->student->toArray());

        // Extract course information
        foreach ($rows as $row) {
            // Log each row for debugging
            Log::info('Processing row:', $row->toArray());

            // Check if the row contains a new academic year and semester
            if (!empty($row[0]) && is_string($row[0])) {
                // Log the raw input for academic year and semester
                Log::info('Raw input for academic year and semester:', [$row[0]]);

                // Define the regex pattern to match the academic year and semester
                $pattern = '/^(.*?)\(Semester (\d+)\s*\)\d*$/';

                // Try to match the pattern
                if (preg_match($pattern, $row[0], $matches)) {
                    // Extract academic year and semester
                    $this->currentAcademicYear = trim($matches[1]); // Academic Year (e.g., "2023 - 2024")
                    $this->currentSemester = trim($matches[2]); // Semester Number (e.g., "2")

                    // Log academic year and semester for debugging
                    Log::info('New academic year and semester detected:', [
                        'academic_year' => $this->currentAcademicYear,
                        'semester' => $this->currentSemester,
                    ]);

                    continue; // Skip to the next row (this row is the semester header)
                } else {
                    // Log if the regex pattern fails to match
                    Log::warning('Regex match failed for input:', [$row[0]]);
                }
            }

            // Check if the row contains course information (e.g., starts with a course number)
            if (!empty($row[0]) && is_string($row[0]) && preg_match('/^[A-Za-z]{4}\d{4}$/', $row[0])) {
                // Validate academic year and semester
                if (empty($this->currentAcademicYear) || empty($this->currentSemester)) {
                    Log::error('Academic year or semester is missing for course:', [$row]);
                    throw new \Exception("Academic year or semester is missing for course: " . json_encode($row));
                }

                // Log the current academic year and semester being used for the course
                Log::info('Using academic year and semester for course:', [
                    'academic_year' => $this->currentAcademicYear,
                    'semester' => $this->currentSemester,
                ]);

                // Create the course record
                $course = Course::create([
                    'student_id' => $this->student->id,
                    'academic_year' => $this->currentAcademicYear,
                    'semester' => $this->currentSemester,
                    'course_no' => $row[0], // Column A (Course No)
                    'course_name' => $row[1], // Column B (Course Name)
                    'credit_hours' => $row[2], // Column C (Credit Hours)
                    'grade' => $row[3], // Column D (Grade)
                    'note' => $row[5] ?? null, // Column F (Note)
                    'points' => $row[4], // Column E (Points)
                    'result' => $row[6], // Column G (Result)
                ]);

                // Log the created course for debugging
                Log::info('Course created:', $course->toArray());
            }
        }
    }
}
