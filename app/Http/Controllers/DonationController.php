<?php

namespace App\Http\Controllers;

use App\Http\Traits\GlobalTrait;
use App\Models\Donation;
use App\Models\DonorProfile;
use App\Models\FundraisingProgram;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonationController extends Controller
{

    use GlobalTrait;

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
        $donations = Donation::with(['user', 'fundraisingProgram', 'dibuat'])
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

        return view('dashboard.transactions.income-transactions.offline-donations.index', [
            'donations' => $donations,
            'donors' => $donors,
            'fundraisingPrograms' => $fundraisingPrograms,
        ]);
    }

    public function storeOfflineDonation(Request $request) {
        $amount = str_replace([',', '.'], '', $request->input('amount'));
        $request->merge(['amount' => $amount]);

        if (!empty($request->amount)) {
            $formattedAmount = number_format($amount, 0, ',', '.');
            session()->flash('originalAmount', $formattedAmount);
        }

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

        $fundraisingProgram = FundraisingProgram::whereNull('deleted_at')
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('status', 'active')
            ->where('id', $validatedData['m_fundraising_program_id'])
            ->first();

        if (!$fundraisingProgram) {
            return redirect()->back()->withInput()->with('error', 'Program penggalangan dana tidak ditemukan.');
        }

        $validatedData['donation_code'] = $this->generateKodeOfflineDonation();
        $validatedData['payment_method'] = 'offline';
        $validatedData['status'] = 'confirmed';

        $donations = Donation::create($validatedData);

        if (!empty($donations) && $donations->id) {
            session()->forget('originalAmount');
            return redirect()->route('transaction.donations.offline-donation.index')
                ->with('success', 'Data Donasi Offline ' . $fundraisingProgram->title . ' berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function updateOfflineDonation(Request $request, $donationId) {
        $this->processRupiahInput($request, 'amount');

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
            session(['edit_donation_offline_id' => $donationId, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $donation = Donation::where('payment_method', 'offline')
            ->where('status', 'confirmed')
            ->where('id', $donationId)
            ->first();

        if (!$donation) {
            return redirect()->back()->withInput()->with('error', 'Data donasi offline tidak ditemukan.');
        }

        $update = Donation::where('id', $donationId)->update($validatedData);

        if ($update) {
            session()->forget('originalAmount');
            return redirect()->route('transaction.donations.offline-donation.index')
                ->with('success', 'Data Donasi Offline berhasil diedit!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function destroyOfflineDonation($donationId) {
        $donation = Donation::where('payment_method', 'offline')
            ->where('status', 'confirmed')
            ->where('id', $donationId)
            ->first();

        if (!$donation) {
            return redirect()->back()->withInput()->with('error', 'Data donasi offline tidak ditemukan.');
        }

        $delete = Donation::destroy($donationId);

        if ($delete) {
            return redirect()->route('transaction.donations.offline-donation.index')->with('success', 'Data donasi offline berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function showOnlineDonationForm($fundraisingProgramId) {
        $fundraisingProgram = FundraisingProgram::whereNull('deleted_at')
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('status', 'active')
            ->where('id', $fundraisingProgramId)
            ->first();

        if (empty($fundraisingProgram)) {
            abort(404);
        }

        $title = $fundraisingProgram->title;

        return view('dashboard.transactions.income-transactions.online-donations.index', [
            'title' => $title,
            'fundraisingProgram' => $fundraisingProgram,
        ]);
    }

    public function storeOnlineDonation(Request $request, $fundraisingProgramId) {
        DB::beginTransaction();

        try {
            $fundraisingProgram = FundraisingProgram::whereNull('deleted_at')
                ->whereDate('end_date', '>=', Carbon::now())
                ->where('status', 'active')
                ->where('id', $fundraisingProgramId)
                ->first();

            if (!$fundraisingProgram) {
                return redirect()->back()->withInput()->with('error', 'Program penggalangan dana tidak ditemukan.');
            }

            $amount = str_replace([',', '.'], '', $request->input('amount'));
            $request->merge(['amount' => $amount]);

            if (!empty($request->amount)) {
                $formattedAmount = number_format($amount, 0, ',', '.');
                session()->flash('originalAmount', $formattedAmount);
            }

            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email:dns',
                'gender' => 'required',
                'phone' => 'required|min:12',
                'address' => 'required',
                'amount' => 'required|numeric|min:0',
                'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            $customMessage = [
                'name.required' => 'Nama lengkap harus diisi!',
                'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Email harus diisi!',
                'email.email' => 'Email yang anda masukkan tidak valid / salah.',
                'gender.required' => 'Jenis kelamin harus diisi!',
                'phone.required' => 'No telepon harus diisi!',
                'phone.min' => 'No telepon yang anda masukkan tidak valid / salah.',
                'address.required' => 'Alamat harus diisi!',
                'amount.required' => 'Jumlah donasi harus diisi!',
                'amount.numeric' => 'Jumlah donasi harus berupa angka atau desimal.',
                'amount.min' => 'Jumlah donasi tidak boleh bernilai negatif.',
                'proof_of_payment.required' => 'Bukti pembayaran harus diunggah!',
                'proof_of_payment.image' => 'Bukti pembayaran yang anda masukkan tidak valid / salah.',
                'proof_of_payment.mimes' => 'Bukti pembayaran harus berupa file bertipe: jpeg, png, atau jpg.',
                'proof_of_payment.max' => 'Ukuran file bukti pembayaran yang anda masukkan terlalu besar!',
            ];

            if(!$request->file('proof_of_payment')) {
                return redirect()->back()->withInput()->with('error', 'Bukti pembayaran harus diunggah!');
            }

            $validatedData = $request->validate($rules, $customMessage);

            $donationCode = $this->generateKodeOnlineDonation();

            $paymentMethod = 'online';
            $status = 'pending';

            $proof_of_payment = $request->file('proof_of_payment');
            $proofPath = $proof_of_payment ? $proof_of_payment->store('proof-of-payment-images', 'public') : null;
            $validatedData['proof_of_payment'] = $proofPath;

            $user = User::where('email', $request->email)->first();

            if(!empty($user)) {
                $donation = Donation::create([
                    'm_user_id' => $user->id,
                    'm_fundraising_program_id' => $fundraisingProgram->id,
                    'donation_code' => $donationCode,
                    'amount' => $validatedData['amount'],
                    'payment_method' => $paymentMethod,
                    'proof_of_payment' => $validatedData['proof_of_payment'],
                    'status' => $status,
                ]);
            } else {
                $donorProfile = DonorProfile::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'gender' => $validatedData['gender'],
                    'phone' => $validatedData['phone'],
                    'address' => $validatedData['address'],
                ]);

                if (!empty($donorProfile) && $donorProfile->id) {
                    $donation = Donation::create([
                        'm_donor_profile_id' => $donorProfile->id,
                        'm_fundraising_program_id' => $fundraisingProgram->id,
                        'donation_code' => $donationCode,
                        'amount' => $validatedData['amount'],
                        'payment_method' => $paymentMethod,
                        'proof_of_payment' => $validatedData['proof_of_payment'],
                        'status' => $status,
                    ]);
                }
            }

            if (!empty($donation) && $donation->id) {
                DB::commit();
                session()->forget('originalAmount');
                return redirect()->route('donations.online.form', $fundraisingProgram->id)
                    ->with('success', 'Donasi Online Program ' . $fundraisingProgram->title . ' berhasil dilakukan! Donasi Anda sedang dalam proses verifikasi oleh admin.');
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data donasi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function listDonorTransferConfirmations(Request $request) {
        $donorTransferConfirmations = Donation::with(['donorProfile', 'fundraisingProgram', 'user', 'dibuat'])
            ->where('payment_method', 'online');

        if ($request->has('donationRejected')) {
            $donorTransferConfirmations->where('status', 'rejected');
        } else {
            $donorTransferConfirmations->where('status', 'pending');
        }

        $donorTransferConfirmations = $donorTransferConfirmations->orderby('created_at', 'desc')
            ->filter(request(['search', 'filterAnonymous']))->paginate(2)->withQueryString();

        return view('dashboard.transactions.donor-transfer-confirmations.index', [
            'donorTransferConfirmations' => $donorTransferConfirmations
        ]);
    }

    public function updateDonorTransferConfirmation($donationId) {
        $donation = Donation::where('payment_method', 'online')
            ->where('status', 'pending')
            ->where('id', $donationId)
            ->first();

        if (!$donation) {
            return redirect()->back()->withInput()->with('error', 'Data donasi online tidak ditemukan.');
        }

        $update = Donation::where('id', $donationId)->update(['status' => 'confirmed']);

        if ($update) {
            return redirect()->route('transaction.donor-transfer-confirmations.index')
                ->with('success', 'Konfirmasi Transfer Donatur berhasil dilakukan!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function updateDonorTransferRejection($donationId) {
        $donation = Donation::where('payment_method', 'online')
            ->where('status', 'pending')
            ->where('id', $donationId)
            ->first();

        if (!$donation) {
            return redirect()->back()->withInput()->with('error', 'Data donasi online tidak ditemukan.');
        }

        $update = Donation::where('id', $donationId)->update(['status' => 'rejected']);

        if ($update) {
            return redirect()->route('transaction.donor-transfer-confirmations.index')
                ->with('success', 'Penolakan konfirmasi transfer donatur berhasil dilakukan!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public static function generateKodeOfflineDonation()
    {
        try {
            $lastKode = Donation::select("donation_code")
                ->whereDate("created_at", Carbon::today())
                ->where("payment_method", "offline")
                ->where(DB::raw("substr(donation_code, 1, 7)"), "=", "DNS/OFF")
                ->orderBy("donation_code", "desc")
                ->first();

            $prefix = "DNS/OFF";
            $currentDate = date("Ymd");

            if ($lastKode) {
                $parts = explode("/", $lastKode->donation_code);
                $lastDate = $parts[2];
                $lastNumber = (int) $parts[3];

                if ($lastDate === $currentDate) {
                    $urutan = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $urutan = "0001";
                }
            } else {
                $urutan = "0001";
            }

            $randomString = strtoupper(Str::random(6));

            $kode = "{$prefix}/{$currentDate}/{$urutan}/{$randomString}";

            return $kode;
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "error" => "Terjadi kesalahan pada server",
                "dev" => $th->getMessage() . " at line " . $th->getLine() . " in " . $th->getFile()
            ];
        }
    }

    public static function generateKodeOnlineDonation()
    {
        try {
            $lastKode = Donation::select("donation_code")
                ->whereDate("created_at", Carbon::today())
                ->where("payment_method", "offline")
                ->where(DB::raw("substr(donation_code, 1, 7)"), "=", "DNS/ONL")
                ->orderBy("donation_code", "desc")
                ->first();

            $prefix = "DNS/ONL";
            $currentDate = date("Ymd");

            if ($lastKode) {
                $parts = explode("/", $lastKode->donation_code);
                $lastDate = $parts[2];
                $lastNumber = (int) $parts[3];

                if ($lastDate === $currentDate) {
                    $urutan = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $urutan = "0001";
                }
            } else {
                $urutan = "0001";
            }

            $randomString = strtoupper(Str::random(6));

            $kode = "{$prefix}/{$currentDate}/{$urutan}/{$randomString}";

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
