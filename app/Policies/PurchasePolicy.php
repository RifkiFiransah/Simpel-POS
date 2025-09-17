<?php 

namespace App\Policies;

use App\Models\Purchase;

class PurchasePolicy extends BaseResourcePolicy {
  protected string $prefix = 'purchases';
}

?>