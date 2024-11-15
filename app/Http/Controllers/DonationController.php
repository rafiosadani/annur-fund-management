<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FundraisingProgram;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }

    public function listOfflineDonations() {
        $donations = Donation::with(['donor', 'fundraisingProgram', 'dibuat'])
            ->where('payment_method', 'offline')
            ->where('status', 'confirmed')
            ->orderby('created_at', 'desc')
            ->orderBy('donation_code', 'asc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        $getRoleDonor = Role::firstWhere('name', 'Donatur');

        if (!empty($getRoleDonor)) {
            $m_role_id = $getRoleDonor->id;
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        $donors = User::whereNull('deleted_at')
            ->where('m_role_id', $m_role_id)
            ->orderby('name', 'asc')
            ->get();

        $fundraisingPrograms = FundraisingProgram::whereNull('deleted_at')
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('status', 'active')
            ->orderBy('title', 'asc')
            ->get();

        return view('dashboard.transactions.offline-donations.index', [
            'donations' => $donations,
            'donors' => $donors,
            'fundraisingPrograms' => $fundraisingPrograms,
        ]);
    }

    public function storeOfflineDonation(Request $request) {
        $amount = str_replace([',', '.'], '', $request->input('amount'));
        $request->merge(['amount' => $amount]);

        $rules = [
            'm_user_id' => 'required',
            'm_fundraising_program_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ];

        $customMessage = [
            'm_user_id.required' => 'Donatur tidak boleh kosong, pilih donatur terlebih dahulu!.',
            'm_fundraising_program_id.required' => 'Program tidak boleh kosong, pilih program terlebih dahulu!.',
            'amount.required' => 'Jumlah donasi harus diisi!',
            'amount.numeric' => 'Jumlah donasi harus berupa angka atau desimal.',
            'amount.min' => 'Jumlah donasi tidak boleh bernilai negatif.'
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $validatedData['donation_code'] = $this->generateKodeOfflineDonation();
        $validatedData['payment_method'] = 'offline';
        $validatedData['status'] = 'confirmed';

        // insert data program
        $donations = Donation::create($validatedData);

        if (!empty($donations)) {
            return redirect()->route('transaction.donations.offline-donation.index')->with('success', 'Data donasi offline berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public static function generateKodeOfflineDonation()
    {
        try {
            // Mengambil kode terakhir
            $last_kode = Donation::select("donation_code")
                ->whereMonth("created_at", Carbon::now())
                ->whereYear("created_at", Carbon::now())
                ->where("payment_method", "offline")
                ->where(DB::raw("substr(donation_code, 1, 7)"), "=", "DNS/OFL")
                ->orderBy("donation_code", "desc")
                ->withTrashed()
                ->first();

            $prefix = "DNS/OFL";
            $year = date("y");
            $month = date("m");

            // Generate Kode
            if ($last_kode) {
                $monthKode = explode("/", $last_kode->donation_code);
                $monthKode = substr($monthKode[2], 2, 4);
                if ($month == $monthKode) {
                    $last = explode("/", $last_kode->donation_code);
                    $last[3] = (int)++$last[3];
                    $urutan = str_pad($last[3], 4, '0', STR_PAD_LEFT);
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
