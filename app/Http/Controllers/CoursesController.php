<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CoursesController extends Controller
{

    public function index()
    {
        $courses = Courses::all();
        return response()->json([
            'message' => 'Data course berhasil diambil.',
            'data' => $courses
        ]);
    }


    public function show($id)
    {
        $courses = Courses::find($id);
        if (!$courses) {
            return response()->json(['message' => 'course tidak ditemukan.'], 404);
        }
        return response()->json([
            'message' => 'Data course ditemukan.',
            'data' => $courses
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'credits' => 'required|string',
            'semester' => 'required|string'
        ]);

        $courses = Courses::create([
            'course_id' => Str::ulid()->toBase32(),
            'name' => $validated['name'],
            'code' => $validated['code'],
            'credits' => $validated['credits'],
            'semester' => $validated['semester'],
        ]);

        return response()->json([
            'message' => 'Data course berhasil ditambahkan.',
            'data' => $courses
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $courses = Courses::find($id);
        if (!$courses) {
            return response()->json(['message' => 'course tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'code' => 'sometimes|required|email',
            'credits' => 'sometimes|required|string',
            'semester' => 'sometimes|required|string'
        ]);

        $courses->update($validated);

        return response()->json([
            'message' => 'Data course berhasil diperbarui.',
            'data' => $courses
        ]);
    }

    public function destroy($id)
    {
        $courses = Courses::find($id);
        if (!$courses) {
            return response()->json(['message' => 'course tidak ditemukan.'], 404);
        }
        $courses->delete();

        return response()->json(['message' => 'Data course berhasil dihapus.']);
    }
}
