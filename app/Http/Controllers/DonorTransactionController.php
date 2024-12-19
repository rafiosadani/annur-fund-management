<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonorTransactionController extends Controller
{
    protected $m_user_id = '';

    protected function setUserId()
    {
        if (!empty(auth()->user())) {
            $this->m_user_id = auth()->user()->id;
        }

        return $this->m_user_id;
    }
    public function listDonations(Request $request){
        $donorDonations = Donation::with(['fundraisingProgram', 'user'])
            ->where('m_user_id', $this->setUserId())
            ->orderBy('created_at', 'desc')
            ->filter(request(['search']))->paginate(10)->withQueryString();

        return view('dashboard.donor-transactions.donation-transactions.index', [
            'donorDonations' => $donorDonations
        ]);
    }
}
