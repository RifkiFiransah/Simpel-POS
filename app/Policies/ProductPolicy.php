<?php 

namespace App\Policies;

use App\Models\Product;

class ProductPolicy extends BaseResourcePolicy {
  protected string $prefix = 'products';
}

?>