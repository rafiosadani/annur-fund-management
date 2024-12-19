<?php

namespace App\Http\Controllers;

use App\Http\Traits\GlobalTrait;
use App\Models\Expense;
use App\Models\FundraisingProgram;
use App\Models\InfaqDonation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    use GlobalTrait;

    public function indexGeneralExpenses()
    {
        $infaqSummary = Expense::calculateInfaqSummary();

        $generalExpenses = Expense::with(['dibuat'])
            ->where('type', 'general')
            ->orderBy('created_at', 'desc')
            ->filter(request(['search', 'program_status']))->paginate(5)->withQueryString();;

        return view('dashboard.transactions.expense-transactions.general-expenses.index', [
            'generalExpenses' => $generalExpenses,
            'totalInfaq' => $infaqSummary['totalInfaq'],
            'totalGeneralExpenses' => $infaqSummary['totalGeneralExpenses'],
            'endingBalance' => $infaqSummary['endingBalance'],
        ]);
    }

    public function storeGeneralExpense(Request $request) {
        $infaqSummary = Expense::calculateInfaqSummary();

        $this->processRupiahInput($request, 'amount');

        $rules = [
            'title' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
        ];

        $customMessage = [
            'title.required' => 'Nama pengeluaran tidak boleh kosong!',
            'title.max' => 'Nama pengeluaran tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah dana harus diisi!',
            'amount.numeric' => 'Jumlah dana harus berupa angka atau desimal.',
            'amount.min' => 'Jumlah dana tidak boleh bernilai negatif.',
            'description.required' => 'Deskripsi harus diisi!',
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

            if ($validatedData['amount'] > $infaqSummary['endingBalance']) {
                session(['create_amount_error' => 'create_amount_error']);
                session()->flash('error_amount', 'Saldo akhir yang tersisa tidak mencukupi untuk pengeluaran yang akan disimpan.');
                return redirect()->back()->withInput()->with('error', 'Saldo akhir yang tersisa tidak mencukupi untuk pengeluaran yang akan disimpan. Mohon periksa kembali jumlah pengeluaran dan saldo akhir yang tersedia.');
            }

            $validatedData['expense_code'] = $this->generateGeneralExpenseCode();
            $validatedData['type'] = 'general';

            $generalExpense = Expense::create($validatedData);

            if (!empty($generalExpense) && $generalExpense->id) {
                DB::commit();
                session()->forget('originalAmount');
                return redirect()->route('transaction.expenses.general-expenses.index')->with('success', 'Transaksi Pengeluaran Umum berhasil dilakukan!');
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data transaksi pengeluaran umum.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function updateGeneralExpense(Request $request, $generalExpenseId) {
        $infaqSummary = Expense::calculateInfaqSummary();

        $this->processRupiahInput($request, 'amount');

        $rules = [
            'title' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
        ];

        $customMessage = [
            'title.required' => 'Nama pengeluaran tidak boleh kosong!',
            'title.max' => 'Nama pengeluaran tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah dana harus diisi!',
            'amount.numeric' => 'Jumlah dana harus berupa angka atau desimal.',
            'amount.min' => 'Jumlah dana tidak boleh bernilai negatif.',
            'description.required' => 'Deskripsi harus diisi!',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_general_expense_id' => $generalExpenseId, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $generalExpense = Expense::where('type', 'general')->find($generalExpenseId);

            if (!$generalExpense) {
                return redirect()->back()->withInput()->with('error', 'Data Transaksi Pengeluaran Umum tidak ditemukan.');
            }

            $availableBalance = intval($generalExpense->amount + $infaqSummary['endingBalance']);

            if ($validatedData['amount'] > $availableBalance) {
                session(['edit_general_expense_id' => $generalExpenseId]);
                session(['create_amount_error' => 'create_amount_error']);
                session()->flash('error_amount', 'Jumlah pengeluaran melebihi saldo yang tersedia (termasuk saldo transaksi sebelumnya).');
                return redirect()->back()->withInput()->with('error', 'Jumlah pengeluaran melebihi saldo yang tersedia. Mohon periksa kembali jumlah pengeluaran dan saldo akhir yang tersedia.');
            }

            $updateGeneralExpense = Expense::where('id', $generalExpenseId)->update($validatedData);

            if ($updateGeneralExpense) {
                DB::commit();
                session()->forget('originalAmount');
                return redirect()->route('transaction.expenses.general-expenses.index')->with('success', 'Transaksi Pengeluaran Umum berhasil diedit!');
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal mengedit data transaksi pengeluaran umum.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function destroyGeneralExpense($generalExpenseId) {
        $generalExpense = Expense::where('type', 'general')->find($generalExpenseId);

        if (!$generalExpense) {
            return redirect()->back()->withInput()->with('error', 'Data Transaksi Pengeluaran Umum tidak ditemukan.');
        }

        $delete = Expense::destroy($generalExpense->id);

        if ($delete) {
            return redirect()->route('transaction.expenses.general-expenses.index')->with('success', 'Transaksi Pengeluaran Umum berhasil dihapus!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data transaksi pengeluaran umum.');
        }
    }

    public function indexProgramExpenses(Request $request) {
        $selectedFundraisingProgramId = $request->get('m_fundraising_program_id');

        $fundraisingPrograms = FundraisingProgram::select('id', 'title')
            ->whereNull('deleted_at')
            ->whereIn('status', ['active', 'completed'])
            ->orderBy('title', 'asc')
            ->get();

        $selectedFundraisingProgram = null;

        if ($selectedFundraisingProgramId) {
            $selectedFundraisingProgram = FundraisingProgram::loadWithDetails($selectedFundraisingProgramId);

            if (!$selectedFundraisingProgram) {
               abort(404);
                // return redirect()->back()->withInput()->with('error', 'Data program penggalangan dana tidak ditemukan.');
            }

            $allExpenses = $selectedFundraisingProgram->expenses()
                ->where('type', 'program')
                ->orderBy('created_at', 'desc')
                ->get();

            $perPage = 4;
            $currentPage = LengthAwarePaginator::resolveCurrentPage('page_expenses');
            $offset = ($currentPage - 1) * $perPage;
            $currentItems = $allExpenses->slice($offset, $perPage)->all();

            $paginatedExpenses = new LengthAwarePaginator($currentItems, $allExpenses->count(), $perPage, $currentPage, ['path' => url()->current(), 'pageName' => 'page_expenses']);

            $selectedFundraisingProgram->setRelation('expenses', $paginatedExpenses);
        }

        $m_fundraising_program_id = $request->query('m_fundraising_program_id');

        return view('dashboard.transactions.expense-transactions.program-expenses.index', [
            'fundraisingPrograms' => $fundraisingPrograms,
            'selectedFundraisingProgramId' => $selectedFundraisingProgramId,
            'selectedFundraisingProgram' => $selectedFundraisingProgram,
            'm_fundraising_program_id' => $m_fundraising_program_id,
        ]);
    }

    public function storeProgramExpense(Request $request) {
        DB::beginTransaction();

        $selectedFundraisingProgramId = $request->input('selectedFundraisingProgramId');

        try {
            if ($selectedFundraisingProgramId) {
                $selectedFundraisingProgram = FundraisingProgram::loadWithDetails($selectedFundraisingProgramId);

                if (!$selectedFundraisingProgram) {
                    return redirect()->back()->withInput()->with('error', 'Program penggalangan dana tidak ditemukan.');
                }

                $this->processRupiahInput($request, 'amount');

                $rules = [
                    'title' => 'required|max:255',
                    'amount' => 'required|numeric|min:0',
                    'description' => 'required',
                ];

                $customMessage = [
                    'title.required' => 'Nama pengeluaran program harus diisi!',
                    'title.max' => 'Nama pengeluaran program tidak boleh lebih dari 255 karakter.',
                    'amount.required' => 'Jumlah pengeluaran harus diisi!',
                    'amount.numeric' => 'Jumlah pengeluaran harus berupa angka atau desimal.',
                    'amount.min' => 'Jumlah pengeluaran tidak boleh bernilai negatif.',
                    'description.required' => 'Keterangan harus diisi!',
                ];

                $validatedData = $request->validate($rules, $customMessage);

                if ($selectedFundraisingProgram->remaining_donations < $validatedData['amount']) {
                    session()->flash('error_amount', 'Dana donasi yang tersisa tidak mencukupi untuk pengeluaran yang akan disimpan.');
                    return redirect()->back()->withInput()->with('error', 'Dana donasi yang tersisa tidak mencukupi untuk pengeluaran yang akan disimpan. Mohon periksa kembali jumlah pengeluaran dan sisa dana yang tersedia.');
                }

                $validatedData['m_fundraising_program_id'] = $selectedFundraisingProgram->id;
                $validatedData['expense_code'] = $this->generateProgramExpenseCode();
                $validatedData['type'] = 'program';

                $expenseProgram = Expense::create($validatedData);

                if (!empty($expenseProgram) && $expenseProgram->id) {
                    DB::commit();
                    session()->forget('originalAmount');
                    return redirect()->route('transaction.expenses.program-expenses.index', [
                        'm_fundraising_program_id' => $selectedFundraisingProgram->id
                    ])->with('success', 'Transaksi Pengeluaran Program ' . $selectedFundraisingProgram->title . ' berhasil dilakukan!');
                }
            }
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal mengedit data transaksi pengeluaran program.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function updateProgramExpense(Request $request, $programExpenseId) {
        $this->processRupiahInput($request, 'amount');

        $rules = [
            'title' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
        ];

        $customMessage = [
            'title.required' => 'Nama pengeluaran program harus diisi!',
            'title.max' => 'Nama pengeluaran program tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah pengeluaran harus diisi!',
            'amount.numeric' => 'Jumlah pengeluaran harus berupa angka atau desimal.',
            'amount.min' => 'Jumlah pengeluaran tidak boleh bernilai negatif.',
            'description.required' => 'Keterangan harus diisi!',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_program_expense_id' => $programExpenseId, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $programExpense = Expense::where('type', 'program')->find($programExpenseId);

            if (!$programExpense) {
                return redirect()->back()->withInput()->with('error', 'Data Transaksi Pengeluaran Program tidak ditemukan.');
            }

            $selectedFundraisingProgram = FundraisingProgram::loadWithDetails($programExpense->m_fundraising_program_id);

            $programAvailableBalance = intval($programExpense->amount + $selectedFundraisingProgram->remaining_donations);

            if ($validatedData['amount'] > $programAvailableBalance) {
                session(['edit_program_expense_id' => $programExpenseId]);
                session(['create_amount_error' => 'create_amount_error']);
                session()->flash('error_amount', 'Jumlah pengeluaran melebihi sisa donasi yang tersedia');
                return redirect()->back()->withInput()->with('error', 'Jumlah pengeluaran melebihi saldo yang tersedia. Mohon periksa kembali jumlah pengeluaran dan sisa donasi yang tersedia.');
            }

            $updateProgramExpense = Expense::where('id', $programExpenseId)->update($validatedData);

            if ($updateProgramExpense) {
                DB::commit();
                session()->forget('originalAmount');
                return redirect()->route('transaction.expenses.program-expenses.index', [
                    'm_fundraising_program_id' => $selectedFundraisingProgram->id
                ])->with('success', 'Transaksi Pengeluaran Program berhasil diedit!');
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal mengedit data transaksi pengeluaran program.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        }
    }

    public function destroyProgramExpense($expenseProgramId) {
        $programExpense = Expense::where('type', 'program')->find($expenseProgramId);

        if (!$programExpense) {
            return redirect()->back()->withInput()->with('error', 'Data Transaksi Pengeluaran Program tidak ditemukan.');
        }

        $delete = Expense::destroy($programExpense->id);

        if ($delete) {
            return redirect()->route('transaction.expenses.program-expenses.index', [
                'm_fundraising_program_id' => $programExpense->m_fundraising_program_id
            ])->with('success', 'Transaksi Pengeluaran Program berhasil dihapus!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data transaksi pengeluaran program.');
        }
    }

    public static function generateGeneralExpenseCode()
    {
        $lastKode = Expense::select("expense_code")
            ->whereDate("created_at", Carbon::today())
            ->where("type", "general")
            ->where(DB::raw("substr(expense_code, 1, 8)"), "=", "TRX/GNRL")
            ->orderBy("created_at", "desc")
            ->first();

        $prefix = "TRX/GNRL";
        $currentDate = date("Ymd");

        if ($lastKode) {
            $parts = explode("/", $lastKode->expense_code);
            $lastDate = $parts[2];
            $lastNumber = (int) $parts[3];

            // Jika tanggalnya sama, increment nomor urut
            if ($lastDate === $currentDate) {
                $urutan = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $urutan = "0001";
            }
        } else {
            // Jika tidak ada kode sebelumnya, mulai dengan urutan 0001
            $urutan = "0001";
        }

        // Menghasilkan string acak untuk memastikan keunikan
        $randomString = strtoupper(Str::random(6));

        // Membuat kode akhir
        $kode = "{$prefix}/{$currentDate}/{$urutan}/{$randomString}";

        return $kode;
    }

    public static function generateProgramExpenseCode()
    {
        $lastKode = Expense::select("expense_code")
            ->whereDate("created_at", Carbon::today())
            ->where("type", "program")
            ->where(DB::raw("substr(expense_code, 1, 8)"), "=", "TRX/PROG")
            ->orderBy("created_at", "desc")
            ->first();

        $prefix = "TRX/PROG";
        $currentDate = date("Ymd");

        if ($lastKode) {
            $parts = explode("/", $lastKode->expense_code);
            $lastDate = $parts[2];
            $lastNumber = (int) $parts[3];

            // Jika tanggalnya sama, increment nomor urut
            if ($lastDate === $currentDate) {
                $urutan = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $urutan = "0001";
            }
        } else {
            // Jika tidak ada kode sebelumnya, mulai dengan urutan 0001
            $urutan = "0001";
        }

        // Menghasilkan string acak untuk memastikan keunikan
        $randomString = strtoupper(Str::random(6));

        // Membuat kode akhir
        $kode = "{$prefix}/{$currentDate}/{$urutan}/{$randomString}";

        return $kode;
    }
}
