<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Models\Salary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salary = Salary::all()->first();

        return new AbsensiResource(true, 'Data Salary Berhasil Ditampilkan', $salary);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salary = Salary::where('user_id', $request->user_id)->where('periode', $request->periode)->first();
        if($salary) {
            return response()->json([
                'error' => 'Penggajian' . $salary->user->name . 'pada periode' . $request->periode . 'Telah Dibayar'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'salary' => 'required',
            'tgl_salary' => 'required|date_format:Y-m-d',
            'periode' => 'required',
            'total' => 'required',
            'status_gaji' => 'required',
            'status' => 'required'
            
        ]);

        if($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        // membuat tanggal untuk saat ini menggunakan DateTime
        $tgl_salary = new DateTime();
        // membuat tanggal menjadi format Y-m-d
        $tgl_salary_format = $tgl_salary->format('Y-m-d');
        // membuat tanggal untuk saat ini menggunakan datetime
        $periode = new DateTime();
        // membuat format tanggal menjadi (Y-m) karna hanya membuatkan periode tahun dan bulan
        $periode_format = $periode->format('Y-m');

        // Hitung total gaji keseluruhan dengan menambahkan jam overtime jika ada
        $total = $request->input('total');
        if ($request->has('lembur')) {
        $total += $request->input('jam_overtime');
        }

        $data = [
            'user_id' => $request->user_id,
            'salary' => $request->salary,
            'tgl_salary' => $tgl_salary_format,
            'periode' => $periode_format,
            'total' => $total,
            'status_gaji' => $request->status_gaji,
            'status' => $request->status,
            'jumlah_overtime' => $request->jumlah_overtime
            

        ];

        $salary = Salary::create($data);

        return new AbsensiResource(true, 'Salary Telah Dibuat', $salary);

        

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

