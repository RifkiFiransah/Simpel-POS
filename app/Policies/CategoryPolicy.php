<?php 

namespace App\Policies;

use App\Models\Category;

class CategoryPolicy extends BaseResourcePolicy {
  protected string $prefix = 'categories';
}

?>