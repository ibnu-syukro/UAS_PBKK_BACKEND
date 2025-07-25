<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentsController extends Controller
{
    public function index()
    {
        $students = Students::all();
        return response()->json([
            'message' => 'Data student berhasil diambil.',
            'data' => $students
        ]);
    }

    public function show($id)
    {
        $students = Students::find($id);
        if (!$students) {
            return response()->json(['message' => 'student tidak ditemukan.'], 404);
        }
        return response()->json([
            'message' => 'Data student ditemukan.',
            'data' => $students
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'NIM' => 'required|string|max:50',
            'major' => 'required|string',
            'enrollment_year' => 'required|date'
        ]);

        $students = Students::create([
            'student_id' => Str::ulid()->toBase32(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'NIM' => $validated['NIM'],
            'major' => $validated['major'],
            'enrollment_year' => $validated['enrollment_year'],
        ]);

        return response()->json([
            'message' => 'Data student berhasil ditambahkan.',
            'data' => $students
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $students = Students::find($id);
        if (!$students) {
            return response()->json(['message' => 'student tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:50',
            'NIM' => 'sometimes|required|string|max:50',
            'major' => 'sometimes|required|string',
            'enrollment_year' => 'sometimes|required|date'
        ]);

        $students->update($validated);

        return response()->json([
            'message' => 'Data student berhasil diperbarui.',
            'data' => $students
        ]);
    }

    public function destroy($id)
    {
        $students = Students::find($id);
        if (!$students) {
            return response()->json(['message' => 'student tidak ditemukan.'], 404);
        }
        $students->delete();

        return response()->json(['message' => 'Data student berhasil dihapus.']);
    }
}
