<?php 

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResourcePolicy {
  protected string $prefix = '';

  public function key(string $action): string {
    return "{$action}_{$this->prefix}";
  }

  public function viewAny(User $user): bool {
    return $user->hasPermission($this->key('view'));
  }

  public function view(User $user, Model $model): bool {
    return $user->hasPermission($this->key('view'));
  }

  public function create(User $user): bool {
    return $user->hasPermission($this->key('create'));
  }

  public function update(User $user, Model $model): bool {
    return $user->hasPermission($this->key('edit'));
  }

  public function delete(User $user, Model $model): bool {
    return $user->hasPermission($this->key('delete'));
  }
}

?>