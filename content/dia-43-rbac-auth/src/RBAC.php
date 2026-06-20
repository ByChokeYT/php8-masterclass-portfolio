<?php
declare(strict_types=1);

namespace App;

class RBAC
{
    private array $rolePermissions = [
        'admin' => ['view_dashboard', 'edit_settings', 'delete_user'],
        'cliente' => ['view_dashboard'],
    ];

    public function hasPermission(string $role, string $permission): bool
    {
        if (!isset($this->rolePermissions[$role])) {
            return false;
        }

        return in_array($permission, $this->rolePermissions[$role], true);
    }
}
