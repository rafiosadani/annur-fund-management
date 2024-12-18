<?php

namespace App\Http\Controllers;

use App\Models\GoodInventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $goods = GoodInventory::with(['dibuat']);

        if ($request->has('view_deleted')) {
            $goods = $goods->onlyTrashed();
        } else {
            $goods = $goods->where('deleted_at', null);
        }

        $goods = $goods->orderBy('created_at', 'desc')
            ->orderBy('good_inventory_code', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        return view('dashboard.goods.index', [
            'goods' => $goods,
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
            'item_name' => 'required|max:255',
            'merk' => 'required|max:255',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
        ];

        $customMessage = [
            'item_name.required' => 'Nama barang harus diisi.',
            'item_name.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',
            'merk.required' => 'Merk barang harus diisi.',
            'merk.max' => 'Merk barang tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi harus diisi!',
            'quantity.required' => 'Jumlah barang harus diisi.',
            'quantity.integer' => 'Jumlah barang harus berupa angka.',
            'quantity.min' => 'Jumlah barang tidak boleh kurang dari 1.',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $validatedData['good_inventory_code'] = $this->generateGoodInventoryCode();

        $good = GoodInventory::create($validatedData);

        if (!empty($good) && $good->id) {
            return redirect()->route('good-inventories.index')->with('success', 'Data barang berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GoodInventory $goodInventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodInventory $goodInventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoodInventory $goodInventory)
    {
        $rules = [
            'item_name' => 'required|max:255',
            'merk' => 'required|max:255',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
        ];

        $customMessage = [
            'item_name.required' => 'Nama barang harus diisi.',
            'item_name.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',
            'merk.required' => 'Merk barang harus diisi.',
            'merk.max' => 'Merk barang tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi harus diisi!',
            'quantity.required' => 'Jumlah barang harus diisi.',
            'quantity.integer' => 'Jumlah barang harus berupa angka.',
            'quantity.min' => 'Jumlah barang tidak boleh kurang dari 1.',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_good_id' => $goodInventory->id, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $goodUpdate = GoodInventory::where('id', $goodInventory->id)->update($validatedData);

        if (!empty($goodUpdate)) {
            return redirect()->route('good-inventories.index')->with('success', 'Data barang berhasil diedit!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodInventory $goodInventory)
    {
        $delete = GoodInventory::destroy($goodInventory->id);

        if ($delete) {
            return redirect()->route('good-inventories.index')->with('success', 'Data barang berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restore(String $id) {
        $goodInventories = GoodInventory::withTrashed()->find($id);

        if(!empty($goodInventories)) {
            $restore = $goodInventories->restore();
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        if (!empty($restore)) {
            return redirect()->back()->with('success', 'Data barang berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restoreAll() {
        $restoreAll = GoodInventory::onlyTrashed()->restore();

        if (!empty($restoreAll)) {
            return redirect()->back()->with('success', 'Data barang berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public static function generateGoodInventoryCode()
    {
        $lastKode = GoodInventory::select("good_inventory_code")
            ->whereDate("created_at", Carbon::today())
            ->where(DB::raw("substr(good_inventory_code, 1, 3)"), "=", "BRG")
            ->orderBy("good_inventory_code", "desc")
            ->first();

        $prefix = "BRG";
        $currentYear = date("y");
        $currentMonth = date("m");

        if ($lastKode) {
            $parts = explode("/", $lastKode->good_inventory_code);
            $lastYear = substr($parts[1], 0, 2);
            $lastMonth = substr($parts[1], 2, 2);
            $lastNumber = (int) $parts[2];

            if ($lastMonth === $currentMonth && $lastYear === $currentYear) {
                $urutan = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $urutan = "0001";
            }
        } else {
            $urutan = "0001";
        }

        $kode = "{$prefix}/{$currentYear}{$currentMonth}/{$urutan}";

        return $kode;
    }
}
