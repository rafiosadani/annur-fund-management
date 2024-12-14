<?php

namespace App\Http\Controllers;

use App\Http\Traits\GlobalTrait;
use App\Models\Expense;
use App\Models\FundraisingProgram;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    use GlobalTrait;

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

//            $selectedFundraisingProgram->total_donated = $selectedFundraisingProgram->total_donated ?? 0;
//            $selectedFundraisingProgram->total_expense = $selectedFundraisingProgram->total_expense ?? 0;
//            $selectedFundraisingProgram->remaining_donations = ($selectedFundraisingProgram->total_donated ?? 0) - ($selectedFundraisingProgram->total_expense ?? 0) ?? 0;
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
                $validatedData['expense_code'] = $this->generateKodeExpenseProgram();
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
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data transaksi pengeluaran program.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->validator);
        }
    }

    public static function generateKodeExpenseProgram()
    {
        $lastKode = Expense::select("expense_code")
            ->whereDate("created_at", Carbon::today())
            ->where("type", "program")
            ->where(DB::raw("substr(expense_code, 1, 7)"), "=", "TRX/PROG")
            ->orderBy("expense_code", "desc")
            ->first();

        $prefix = "TRX/PROG";
        $currentDate = date("Ymd");

        if ($lastKode) {
            $parts = explode("/", $lastKode->expense_code);
            $lastDate = $parts[1];
            $lastNumber = (int) $parts[2];

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
