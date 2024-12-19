<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->check()) {
            $m_user_id = auth()->user()->id;
        }

        $isDonor = auth()->check() && auth()->user()->hasRole('Donatur');
        $isAdmin = auth()->check() && auth()->user()->hasRole('Administrator');

        if ($isAdmin) {
            $infaqSummary = Expense::calculateInfaqSummary();
            $totalDonations = Donation::where('status', 'confirmed')->sum('amount') ?? 0;
            $totalProgramExpenses = Expense::where('type', 'program')->sum('amount') ?? 0;
            $remainingDonations = intval(($totalDonations ?? 0) - ($totalProgramExpenses ?? 0)) ?? 0;

            $data = [
                'totalInfaq' => $infaqSummary['totalInfaq'],
                'totalGeneralExpenses' => $infaqSummary['totalGeneralExpenses'],
                'endingBalance' => $infaqSummary['endingBalance'],
                'totalDonations' => $totalDonations,
                'totalProgramExpenses' => $totalProgramExpenses,
                'remainingDonations' => $remainingDonations,
            ];
        } elseif ($isDonor) {
            $totalDonorDonations = Donation::where('m_user_id', $m_user_id)->where('status', 'confirmed')->sum('amount') ?? 0;
            $countProgramDonation = Donation::where('m_user_id', $m_user_id)
                ->whereNotNull('m_fundraising_program_id')
                ->distinct('m_fundraising_program_id')
                ->count();

            $donorDonations = Donation::with(['fundraisingProgram', 'user'])
                ->where('m_user_id', $m_user_id)
                ->orderBy('created_at', 'desc')
                ->filter(request(['search']))->paginate(10)->withQueryString();

            $data = [
                'totalDonorDonations' => $totalDonorDonations,
                'countProgramDonation' => $countProgramDonation,
                'donorDonations' => $donorDonations,
            ];
        }

        return view('dashboard.index', [
            'data' => $data,
        ]);
    }
}
