<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    // Get All Classes (with sorting)
    public function index()
    {
        $classes = ClassModel::all()->toArray();

        usort($classes, function ($a, $b) {
            $jadwalA = (new ClassModel($a))->parseJadwal();
            $jadwalB = (new ClassModel($b))->parseJadwal();

            $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $dayA = array_search($jadwalA['hari'], $daysOrder);
            $dayB = array_search($jadwalB['hari'], $daysOrder);

            if ($dayA != $dayB) {
                return $dayA - $dayB;
            }
            return strtotime($jadwalA['jam_mulai']) - strtotime($jadwalB['jam_mulai']);
        });

        return response()->json($classes);
    }

    // Get Classes by User
    public function indexByUser($user_id)
    {
        $classes = ClassModel::where('user_id', $user_id)->get()->toArray();

        usort($classes, function ($a, $b) {
            $jadwalA = (new ClassModel($a))->parseJadwal();
            $jadwalB = (new ClassModel($b))->parseJadwal();

            $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $dayA = array_search($jadwalA['hari'], $daysOrder);
            $dayB = array_search($jadwalB['hari'], $daysOrder);

            if ($dayA != $dayB) {
                return $dayA - $dayB;
            }
            return strtotime($jadwalA['jam_mulai']) - strtotime($jadwalB['jam_mulai']);
        });

        return response()->json($classes);
    }

    // Store New Class
    public function store(Request $request, $user_id = null)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas'     => 'required|string',
            'mata_pelajaran' => 'required|string',
            'nama_pengajar'  => 'required|string',
            'jadwal'         => 'required|string|regex:/^[A-Za-z]+, [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}$/',
            'deskripsi'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        if ($user_id) {
            $data['user_id'] = $user_id;
        }

        $class = ClassModel::create($data);

        return response()->json([
            'message' => 'Kelas berhasil ditambahkan',
            'data' => $class,
        ], 201);
    }

    // Show Class by ID
    public function show($id)
    {
        $class = ClassModel::find($id);

        if (!$class) {
            return response()->json(['message' => 'Kelas tidak ditemukan'], 404);
        }

        return response()->json($class);
    }

    // Update Class
    public function update(Request $request, $id)
    {
        $class = ClassModel::find($id);

        if (!$class) {
            return response()->json(['message' => 'Kelas tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_kelas'     => 'required|string',
            'mata_pelajaran' => 'required|string',
            'nama_pengajar'  => 'required|string',
            'jadwal'         => 'required|string|regex:/^[A-Za-z]+, [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}$/',
            'deskripsi'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $class->update($request->all());

        return response()->json([
            'message' => 'Kelas berhasil diupdate',
            'data'    => $class,
        ]);
    }

    // Delete Class
    public function destroy($id)
    {
        $class = ClassModel::find($id);

        if (!$class) {
            return response()->json(['message' => 'Kelas tidak ditemukan'], 404);
        }

        $class->delete();

        return response()->json(['message' => 'Kelas berhasil dihapus']);
    }
}