<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transactionId;
    protected $status;

    public function __construct($transactionId, $status)
    {
        $this->transactionId = $transactionId;
        $this->status = $status;
    }

    public function handle()
    {
        $transaction = Transaction::find($this->transactionId);
        $transaction->update(['status' => $this->status]);
    }
}

