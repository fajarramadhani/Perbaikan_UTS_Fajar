<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient = Patient::all();

        $totalData = count($patient);

        if ($totalData) {
            $data = [
                'message' => 'Semua Data Berhasil Di Tampilkan',
                'total patients' => $totalData,
                'data patients' => $patient
            ];

            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Semua Data Tidak Ada',
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'name' => 'required|max:50|unique:patients,name',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => 'required|max:11',
            'in_date_at' => 'required',
            'out_date_at' => 'nullable'
        ]);

        $patients = Patient::create($validasi);

        $data = [
            'message' => 'Data Berhasil Di Tambahkan',
            'data' => $patients
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patients = Patient::find($id);

        if ($patients) {
            $data = [
                'message' => 'Detail Data Berhasil Di Tampilkan',
                'data' => $patients
            ];
            return response()->json($data, 200);
        }
        $data = [
            'message' => "Data Tidak Berhasil Di Tampilkan"
        ];

        return response()->json($data, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $patients = Patient::find($id);

        if ($patients) {
            $patients->update($request->all());
            $data = [
                'message' => 'Data Berhasil Di Update',
                'data' => $patients
            ];

            return response()->json($data, 200);
        }
        $data = [
            'message' => 'Data Tidak Ditemukan'
        ];

        return response()->json($data, 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patients = Patient::find($id);

        if ($patients) {
            $patients->delete();
            $data = [
                'message' => 'Data Berhasil Dihapus'
            ];

            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Data Tidak Di Temukan'
        ];

        return response()->json($data, 404);
    }
    public function search($name)
    {
        $patients = Patient::where('name', 'like', '%' . $name . '%')->get();

        $total = count($patients);

        if ($total) {
            $data = [
                'message' => 'Nama Tersebut Berhasil Ditampilkan',
                'total' => $total,
                'data' => $patients
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Nama Tersebut Tidak Ditemukan'
            ];

            return response()->json($data, 404);
        }
    }

    public function positive()
    {
        $patients = Patient::where('status', 'positive')->get();
        $total = count($patients);

        if ($total) {
            $data = [
                'message' => 'Data Dengan Status Positif Berhasil Ditampilkan',
                'total patients' => $total,
                'data patients' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data Tersebut Kosong',
                'total patients' => $total
            ];
            return response()->json($data, 200);
        }
    }

    public function  recovered()
    {
        $patients = Patient::where('status', 'recovered')->get();
        $total = count($patients);

        if ($total) {
            $data = [
                'message' => 'Data Dengan Status Sembuh Berhasil Ditampilkan',
                'total patients' => $total,
                'data patients' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data is empty',
                'total patients' => $total
            ];
            return response()->json($data, 200);
        }
    }

    public function dead()
    {
        $patients = Patient::where('status', 'dead')->get();
        $total = count($patients);

        if ($total) {
            $data = [
                'message' => 'Data Dengan Status Meninggal Berhasil Ditampilkan',
                'total patients' => $total,
                'data patients' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data Tersebut Kosong',
                'total patients' => $total
            ];
            return response()->json($data, 200);
        }
    }
}
