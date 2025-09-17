<?php 

namespace App\Policies;

use App\Models\Customer;

class CustomerPolicy extends BaseResourcePolicy {
  protected string $prefix = 'customers';
}

?>