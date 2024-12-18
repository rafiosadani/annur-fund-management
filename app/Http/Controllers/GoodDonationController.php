<?php

namespace App\Http\Controllers;

use App\Models\GoodDonation;
use App\Models\GoodInventory;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoodDonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $goodDonations = GoodDonation::with(['good', 'user', 'dibuat'])
            ->orderBy('created_at', 'desc')
            ->orderBy('good_donation_code', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        $goods = GoodInventory::whereNull('deleted_at')
            ->orderBy('item_name', 'asc')
            ->get();

        $getRoleDonor = Role::firstWhere('name', 'Donatur');

        if (!empty($getRoleDonor)) {
            $m_role_id = $getRoleDonor->id;
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        $users = User::whereNull('deleted_at')
            ->where('m_role_id', $m_role_id)
            ->orderby('name', 'asc')
            ->get();

        return view('dashboard.transactions.goods-transaction.index', [
            'goodDonations' => $goodDonations,
            'goods' => $goods,
            'users' => $users,
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
        $rules = [
            'm_good_inventory_id' => 'required',
            'm_user_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'note' => 'required',
        ];

        $customMessage = [
            'm_good_inventory_id.required' => 'Barang tidak boleh kosong, pilih barang terlebih dahulu!.',
            'm_user_id.required' => 'Donatur tidak boleh kosong, pilih donatur terlebih dahulu!.',
            'quantity.required' => 'Jumlah barang harus diisi.',
            'quantity.integer' => 'Jumlah barang harus berupa angka.',
            'quantity.min' => 'Jumlah barang tidak boleh kurang dari 1.',
            'note.required' => 'Keterangan harus diisi!',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $validatedData['good_donation_code'] = $this->generateGoodDonationCode();

            $goodDonation = GoodDonation::create($validatedData);

            // update quantity good inventories
            $goodInventory = GoodInventory::find($goodDonation->m_good_inventory_id);
            $goodInventory->quantity += $validatedData['quantity'];
            $isSaved = $goodInventory->save();

            if (!empty($goodDonation) && $goodDonation->id && $isSaved) {
                DB::commit();
                return redirect()->route('good-donations.index')->with('success', 'Transaksi Donasi Barang berhasil dilakukan!');
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data transaksi donasi barang.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GoodDonation $goodDonation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodDonation $goodDonation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoodDonation $goodDonation)
    {
        $rules = [
            'm_good_inventory_id' => 'required',
            'm_user_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'note' => 'required',
        ];

        $customMessage = [
            'm_good_inventory_id.required' => 'Barang tidak boleh kosong, pilih barang terlebih dahulu!.',
            'm_user_id.required' => 'Donatur tidak boleh kosong, pilih donatur terlebih dahulu!.',
            'quantity.required' => 'Jumlah barang harus diisi.',
            'quantity.integer' => 'Jumlah barang harus berupa angka.',
            'quantity.min' => 'Jumlah barang tidak boleh kurang dari 1.',
            'note.required' => 'Keterangan harus diisi!',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_good_donation_id' => $goodDonation->id, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $oldGoodInventory = GoodInventory::find($goodDonation->m_good_inventory_id);

            if (!$oldGoodInventory) {
                return redirect()->back()->withInput()->with('error', 'Barang tidak ditemukan.');
            }

            $isInventoryChanged = $validatedData['m_good_inventory_id'] !== $goodDonation->m_good_inventory_id;

            if ($isInventoryChanged) {
                $oldGoodInventory->quantity -= $goodDonation['quantity'];
                $oldGoodInventory->save();

                // get new selected item data
                $newGoodInventory = GoodInventory::find($validatedData['m_good_inventory_id']);

                if (!$newGoodInventory) {
                    return redirect()->back()->withInput()->with('error', 'Barang tidak ditemukan.');
                }

                $newGoodInventory->quantity += $validatedData['quantity'];
                $isSaved = $newGoodInventory->save();
            } else {
                $quantityDifference = $validatedData['quantity'] - $goodDonation->quantity;

                $oldGoodInventory->quantity += $quantityDifference;
                $isSaved = $oldGoodInventory->save();
            }

            $updateGoodDonation = GoodDonation::where('id', $goodDonation->id)->update($validatedData);

            if (!empty($updateGoodDonation) && $isSaved) {
                DB::commit();
                return redirect()->route('good-donations.index')->with('success', 'Transaksi Donasi Barang berhasil diedit!');
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal mengedit data transaksi donasi barang.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodDonation $goodDonation)
    {
        $goodInventory = GoodInventory::find($goodDonation->m_good_inventory_id);

        if (!$goodInventory) {
            return redirect()->back()->withInput()->with('error', 'Barang tidak ditemukan.');
        }

        $goodInventory->quantity -= $goodDonation->quantity;
        $isSaved = $goodInventory->save();

        $delete = GoodDonation::destroy($goodDonation->id);

        if ($delete && $isSaved) {
            return redirect()->route('good-donations.index')->with('success', 'Transaksi Donasi Barang berhasil dihapus!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data transaksi donasi barang.');
        }
    }

    public static function generateGoodDonationCode()
    {
        $lastKode = GoodDonation::select("good_donation_code")
            ->whereDate("created_at", Carbon::today())
            ->where(DB::raw("substr(good_donation_code, 1, 7)"), "=", "DNS/BRG")
            ->orderBy("good_donation_code", "desc")
            ->first();

        $prefix = "DNS/BRG";
        $currentDate = date("Ymd");

        if ($lastKode) {
            $parts = explode("/", $lastKode->good_donation_code);
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
    }
}
