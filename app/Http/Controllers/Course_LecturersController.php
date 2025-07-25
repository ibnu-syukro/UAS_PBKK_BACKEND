<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Course_Lecturers;

class Course_LecturersController extends Controller
{
    public function index()
    {
        $course_lecturer = Course_Lecturers::with(['course', 'lecturer'])->get();

        return response()->json([
            'message' => 'Daftar course_lecturer.',
            'data' => $course_lecturer
        ]);
    }

    
    public function show($id)
    {
        $course_lecturer = Course_Lecturers::with(['course', 'lecturer'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail course_lecturer.',
            'data' => $course_lecturer
        ]);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|string|exists:courses,course_id',
            'lecturer_id' => 'required|string|exists:lecturers,lecturer_id',
            'role' => 'required|string'
        ]);

        $course_lecturer = Course_Lecturers::create([
            'id' => Str::ulid()->toBase32(),  
            'course_id' => $validated['course_id'],
            'lecturer_id' => $validated['lecturer_id'],
            'role' => $validated['role'],
            
        ]);

        return response()->json([
            'message' => 'Course_Lecturers berhasil ditambahkan.',
            'data' => $course_lecturer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $course_lecturer = Course_Lecturers::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'sometimes|required|string',
            'lecturer_id' => 'sometimes|required|string',
            'role' => 'sometimes|required|string',
        ]);

        $course_lecturer->update($validated);

        return response()->json([
            'message' => 'Course_Lecturers berhasil diupdate.',
            'data' => $course_lecturer
        ]);
    }


    public function destroy($id)
    {
        $course_lecturer = Course_Lecturers::find($id);
        if (!$course_lecturer) {
            return response()->json(['message' => 'Course_Lecturers tidak ditemukan.'], 404);
        }
        $course_lecturer->delete();

        return response()->json(['message' => 'Course_Lecturers berhasil dihapus.']);
    }
}


