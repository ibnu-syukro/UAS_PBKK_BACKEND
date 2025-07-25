<?php

namespace App\Http\Controllers;

use App\Models\Lecturers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LecturersController extends Controller
{
    public function index()
    {
        $lecturers = Lecturers::all();
        return response()->json([
            'message' => 'Data lecturer berhasil diambil.',
            'data' => $lecturers
        ]);
    }

  
    public function show($id)
    {
        $lecturers = Lecturers::find($id);
        if (!$lecturers) {
            return response()->json(['message' => 'lecturer tidak ditemukan.'], 404);
        }
        return response()->json([
            'message' => 'Data lecturer ditemukan.',
            'data' => $lecturers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'NIP' => 'required|string',
            'department' => 'required|string',
            'email' => 'required|email'
        ]);

        $lecturers = Lecturers::create([
            'lecturer_id' => Str::ulid()->toBase32(),
            'name' => $validated['name'],
            'NIP' => $validated['NIP'],
            'department' => $validated['department'],
            'email' => $validated['email'],
        ]);

        return response()->json([
            'message' => 'Data lecturer berhasil ditambahkan.',
            'data' => $lecturers
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $lecturers = Lecturers::find($id);
        if (!$lecturers) {
            return response()->json(['message' => 'lecturer tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'NIP' => 'sometimes|required|string',
            'depatment' => 'sometimes|required|string',
            'email' => 'sometimes|required|email'
        ]);

        $lecturers->update($validated);

        return response()->json([
            'message' => 'Data lecturer berhasil diperbarui.',
            'data' => $lecturers
        ]);
    }

    public function destroy($id)
    {
        $lecturers = Lecturers::find($id);
        if (!$lecturers) {
            return response()->json(['message' => 'lecturer tidak ditemukan.'], 404);
        }
        $lecturers->delete();

        return response()->json(['message' => 'Data lecturer berhasil dihapus.']);
    }
}


