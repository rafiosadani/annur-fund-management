<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['dibuat'])
            ->where('deleted_at', null)
            ->orderBy('created_at', 'desc')
            ->orderBy('user_code', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        return view('dashboard.users.index', [
            'users' => $users
        ]);
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
        //
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

    public static function generateKode()
    {
        try {
            // Mengambil kode terakhir
            $last_kode = User::select("user_code")
                ->whereMonth("created_at", Carbon::now())
                ->whereYear("created_at", Carbon::now())
                ->where(DB::raw("substr(user_code, 1, 3)"), "=", "USR")
                ->orderBy("user_code", "desc")
                ->withTrashed()
                ->first();

            $prefix = "USR";
            $year = date("y");
            $month = date("m");

            // Generate Kode
            if ($last_kode) {
                $monthKode = explode("/", $last_kode->user_code);
                $monthKode = substr($monthKode[1], 2, 4);
                if ($month == $monthKode) {
                    $last = explode("/", $last_kode->user_code);
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
