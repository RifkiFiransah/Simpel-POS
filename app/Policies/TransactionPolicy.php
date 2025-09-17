<?php 

namespace App\Policies;

use App\Models\Transaction;

class TransactionPolicy extends BaseResourcePolicy {
  protected string $prefix = 'transactions';
}

?>