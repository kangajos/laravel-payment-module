<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    public function processTransaction(Request $request)
    {
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // Assume payment processing here and update status
        $status = $this->processPayment($transaction);

        // Queue transaction update
        ProcessTransactionJob::dispatch($transaction->id, $status);

        return response()->json(['message' => 'Transaction is being processed']);
    }

    public function userTransactions(Request $request)
    {
        $transactions = Cache::remember('user:'.auth()->id().':transactions', 60, function () {
            return auth()->user()->transactions()->paginate(10);
        });

        return response()->json($transactions);
    }

    public function transactionSummary()
    {
        $summary = Cache::remember('user:'.auth()->id().':summary', 60, function () {
            $transactions = auth()->user()->transactions;

            return [
                'total_transactions' => $transactions->count(),
                'average_amount' => $transactions->average('amount'),
                'highest_transaction' => $transactions->sortByDesc('amount')->first(),
                'lowest_transaction' => $transactions->sortBy('amount')->first(),
                'longest_name_transaction' => $transactions->sortByDesc(function ($transaction) {
                    return strlen($transaction->user->name);
                })->first(),
                'status_distribution' => $transactions->groupBy('status')->map->count(),
            ];
        });

        return response()->json($summary);
    }

    private function processPayment(Transaction $transaction)
    {
        // Dummy payment processing logic
        return rand(0, 1) ? 'completed' : 'failed';
    }
}
