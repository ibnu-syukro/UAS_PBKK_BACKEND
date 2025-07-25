<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{

    public function index()
    {
        $enrollment = Enrollment::with(['student', 'course'])->get();

        return response()->json([
            'message' => 'Daftar enrollment.',
            'data' => $enrollment
        ]);
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail enrollment.',
            'data' => $enrollment
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|exists:students,student_id',
            'course_id' => 'required|string|exists:courses,course_id',
            'grade' => 'nullable|string',
            'attendance' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $enrollment = Enrollment::create([
            'enrollment_id' => Str::ulid()->toBase32(), 
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'grade' => $validated['grade'],
            'attendance' => $validated['attendance'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Enrollment berhasil ditambahkan.',
            'data' => $enrollment
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'sometimes|required|string',
            'course_id' => 'sometimes|required|string',
            'grade' => 'sometimes|required|string',
            'attendance' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
        ]);

        $enrollment->update($validated);

        return response()->json([
            'message' => 'Enrollment berhasil diupdate.',
            'data' => $enrollment
        ]);
    }
    
    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment tidak ditemukan.'], 404);
        }
        $enrollment->delete();

        return response()->json(['message' => 'Data Enrollment berhasil dihapus.']);
    }
}
