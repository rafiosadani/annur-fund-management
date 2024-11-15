<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use Database\Seeders\InfaqTypeSeeder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InfaqController extends Controller
{
     // Fungsi untuk menampilkan semua data infaq
     public function index(Request $request)
     {
        $search = $request->input('search');
        $infaqTypes = Infaq::orderBy('infaq_type_code', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();
        return view('dashboard.charitable-donations.index', compact('infaqTypes'));
     }
 
     // Fungsi untuk menampilkan detail dari satu data infaq berdasarkan id
     public function show($id)
     {
         //
     }

     public function update(Request $request, Infaq $infaq)
    {
        $rules = [
            'type_name' => 'required',
            'description' => 'required',
        ];

        $customMessage = [
            'type_name.required' => 'Nama tipe infaq tidak boleh kosong, isi terlebih dahulu!.',
            'descriptions.required' => 'Deskripsi tidak boleh kosong, isi terlebih dahulu!.',
        ];

        // Validasi
        $validatedData = $request->validate($rules, $customMessage);

        $validatedData['infaq_type_code']=$this->generateKode();

        // Simpan data
        $updateInfaq = Infaq::where('id', $infaq->id)->update($validatedData);

        if ($updateInfaq) {
            return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil diedit!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }
 
     // Fungsi untuk menambah data infaq
     public function store(Request $request)
     {
        $request->validate([
            'type_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        // Buat data infaq baru menggunakan data yang diinputkan
        Infaq::create([
            'type_name' => $request->input('type_name'),
            'infaq_type_code' => $this->generateKode(),
            'description' => $request->input('description'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    
        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('master.charitable-donations.index')->with('success', 'Data Infaq berhasil ditambahkan.');
     }
 
     // Fungsi untuk menghapus data infaq
     public function destroy(Infaq $infaq)
     {
        $delete = Infaq::destroy($infaq->id);

        if ($delete) {
            return redirect()->route('infaq.index')->with('success', 'Data infaq- berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
     }

     public static function generateKode()
    {
        try {
            // Mengambil kode terakhir
            $last_kode = Infaq::select("infaq_type_code")
                ->whereMonth("created_at", Carbon::now())
                ->whereYear("created_at", Carbon::now())
                ->where(DB::raw("substr(infaq_type_code, 1, 3)"), "=", "INQ")
                ->orderBy("infaq_type_code", "desc")
                ->withTrashed()
                ->first();

            $prefix = "INQ";
            $year = date("y");
            $month = date("m");

            // Generate Kode
            if ($last_kode) {
                $monthKode = explode("/", $last_kode->infaq_type_code);
                $monthKode = substr($monthKode[1], 2, 4);
                if ($month == $monthKode) {
                    $last = explode("/", $last_kode->infaq_type_code);
                    $last[2] = (int)++$last[2];
                    $urutan = str_pad($last[2], 4, '0', STR_PAD_LEFT);
                    $kode = $prefix . "/" . $year . $month . "/" . $urutan;
                } else {
                    $kode = $prefix . "/" . $year . $month . "/" . "0001";
                }
            } else {
                $kode = $prefix . "/" . $year . $month . "/" . "0001";
            }

            return $kode;
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "error" => "Terjadi kesalahan pada server",
                "dev" => $th->getMessage() . " at line " . $th->getLine() . " in " . $th->getFile()
            ];
        }
    }
}
