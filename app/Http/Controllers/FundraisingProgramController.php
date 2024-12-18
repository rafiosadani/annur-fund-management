<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginationTrait;
use App\Models\FundraisingProgram;
use App\Models\FundraisingProgramImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FundraisingProgramController extends Controller
{
    use PaginationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fundraisingPrograms = FundraisingProgram::with(['dibuat', 'images'])
            ->withSum(['donations as total_donated' => function($query) {
                $query->where('status', 'confirmed');
            }], 'amount')
            ->withSum(['expenses as total_expense' => function ($query) {
                $query->where('type', 'program');
            }], 'amount');

        if ($request->has('view_deleted')) {
            $fundraisingPrograms = $fundraisingPrograms->onlyTrashed();
        } else {
            $fundraisingPrograms = $fundraisingPrograms->where('deleted_at', null);
        }

        $fundraisingPrograms = $fundraisingPrograms->orderBy('created_at', 'desc')
            ->orderBy('fundraising_program_code', 'asc')
            ->filter(request(['search', 'program_status']))->paginate(5)->withQueryString();

        foreach ($fundraisingPrograms as $fundraisingProgram) {
            $allDonationsQuery = $fundraisingProgram->donations()
                ->where('status', 'confirmed')
                ->with(['user', 'donorProfile']);

            $this->setPaginatedRelation($fundraisingProgram, 'donations', $allDonationsQuery, 4, 'page_donations');

            $allExpensesQuery = $fundraisingProgram->expenses()
                ->where('type', 'program')
                ->orderBy('created_at', 'desc');

            $this->setPaginatedRelation($fundraisingProgram, 'expenses', $allExpensesQuery, 4, 'page_expenses');

            $fundraisingProgram->total_donated = intval($fundraisingProgram->total_donated) ?? 0;
            $fundraisingProgram->total_expense = intval($fundraisingProgram->total_expense) ?? 0;
            $fundraisingProgram->donation_percentage = $fundraisingProgram->target_amount > 0
                ? min(intval(round(($fundraisingProgram->total_donated / $fundraisingProgram->target_amount) * 100)), 100)
                : 0;
        }

        $openModal = $request->query('openModal');

        return view('dashboard.fundraising-programs.index', [
            'fundraisingPrograms' => $fundraisingPrograms,
            'openModal' => $openModal
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
        $targetAmount = str_replace([',', '.'], '', $request->input('target_amount'));
        $request->merge(['target_amount' => $targetAmount]);

        $rules = [
            'title' => 'required|max:255',
            'target_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $customMessage = [
            'title.required' => 'Nama program harus diisi!',
            'title.max' => 'Nama program tidak boleh lebih dari 255 karakter.',
            'target_amount.required' => 'Target donasi harus diisi!',
            'target_amount.numeric' => 'Target donasi harus berupa angka atau desimal.',
            'target_amount.min' => 'Target donasi tidak boleh bernilai negatif.',
            'start_date.required' => 'Tanggal mulai harus diisi!',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal akhir harus diisi!',
            'end_date.date' => 'Format tanggal akhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',
            'status.required' => 'Status harus diisi!',
            'description.required' => 'Deskripsi harus diisi!',
            'image.image' => 'Gambar yang anda masukkan tidak valid.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, gif.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $validatedData['fundraising_program_code'] = $this->generateKode();

        // insert data program
        $fundraisingProgram = FundraisingProgram::create($validatedData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('fundraising-program-images', 'public');

                FundraisingProgramImage::create([
                    'm_fundraising_program_id' => $fundraisingProgram->id,
                    'image' => $imagePath,
                ]);
            }
        }

        if (!empty($fundraisingProgram)) {
            return redirect()->route('fundraising-programs.index')->with('success', 'Data program berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FundraisingProgram $fundraisingProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundraisingProgram $fundraisingProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FundraisingProgram $fundraisingProgram)
    {
        $targetAmount = str_replace([',', '.'], '', $request->input('target_amount'));
        $request->merge(['target_amount' => $targetAmount]);

        $rules = [
            'title' => 'required|max:255',
            'target_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $customMessage = [
            'title.required' => 'Nama program harus diisi!',
            'title.max' => 'Nama program tidak boleh lebih dari 255 karakter.',
            'target_amount.required' => 'Target donasi harus diisi!',
            'target_amount.numeric' => 'Target donasi harus berupa angka atau desimal.',
            'target_amount.min' => 'Target donasi tidak boleh bernilai negatif.',
            'start_date.required' => 'Tanggal mulai harus diisi!',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal akhir harus diisi!',
            'end_date.date' => 'Format tanggal akhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',
            'status.required' => 'Status harus diisi!',
            'description.required' => 'Deskripsi harus diisi!',
            'image.image' => 'Gambar yang anda masukkan tidak valid.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, gif.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ];

        // Validation input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_fundraising_program_id' => $fundraisingProgram->id, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Handle images marked for deletion
        if ($request->has('images_to_delete')) {
            $imagesToDelete = json_decode($request->images_to_delete, true);
            if (is_array($imagesToDelete)) {
                foreach ($imagesToDelete as $imageId) {
                    $image = $fundraisingProgram->images()->find($imageId);
                    if ($image) {
                        Storage::delete($image->image);
                        $image->delete();
                    }
                }
            }
        }

        // Handle new images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('fundraising-program-images', 'public');

                $fundraisingProgram->images()->create(['image' => $path]);
            }
        }

        $updateFundraisingProgram = FundraisingProgram::where('id', $fundraisingProgram->id)->update($validatedData);

        if (!empty($updateFundraisingProgram)) {
            return redirect()->route('fundraising-programs.index')->with('success', 'Data program berhasil diedit!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundraisingProgram $fundraisingProgram)
    {
        $delete = FundraisingProgram::destroy($fundraisingProgram->id);

        if ($delete) {
            return redirect()->route('fundraising-programs.index')->with('success', 'Data program berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restore(String $id) {
        $dataFundraisingProgram = FundraisingProgram::withTrashed()->find($id);

        if(!empty($dataFundraisingProgram)) {
            $restore = $dataFundraisingProgram->restore();
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        if (!empty($restore)) {
            return redirect()->back()->with('success', 'Data program berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restoreAll() {
        $restoreAll = FundraisingProgram::onlyTrashed()->restore();

        if (!empty($restoreAll)) {
            return redirect()->back()->with('success', 'Data program berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public static function generateKode()
    {
        try {
            // Mengambil kode terakhir
            $last_kode = FundraisingProgram::select("fundraising_program_code")
                ->whereMonth("created_at", Carbon::now())
                ->whereYear("created_at", Carbon::now())
                ->where(DB::raw("substr(fundraising_program_code, 1, 3)"), "=", "PRG")
                ->orderBy("fundraising_program_code", "desc")
                ->withTrashed()
                ->first();

            $prefix = "PRG";
            $year = date("y");
            $month = date("m");

            // Generate Kode
            if ($last_kode) {
                $monthKode = explode("/", $last_kode->fundraising_program_code);
                $monthKode = substr($monthKode[1], 2, 4);
                if ($month == $monthKode) {
                    $last = explode("/", $last_kode->fundraising_program_code);
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
