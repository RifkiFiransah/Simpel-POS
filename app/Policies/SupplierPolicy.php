<?php 

namespace App\Policies;

use App\Models\Supplier;

class SupplierPolicy extends BaseResourcePolicy {
  protected string $prefix = 'suppliers';
}

?>