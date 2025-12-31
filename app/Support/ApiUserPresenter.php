<?php

namespace App\Support;

final class ApiUserPresenter
{
    public function present(array $data): array
    {
        $user = $data['user'] ?? [];

        $name = $user['name'] ?? 'Usuario';

        // roles puede venir en data.roles o en user.roles
        $roles = $data['roles'] ?? ($user['roles'] ?? []);

        // Normaliza role (primer elemento)
        $firstRole = null;

        if (is_array($roles)) {
            $firstRole = $roles[0] ?? null;

            // si viene como objeto/array {name: "admin"} o {role: "admin"}
            if (is_array($firstRole)) {
                $firstRole = $firstRole['name'] ?? $firstRole['role'] ?? $firstRole['slug'] ?? null;
            }
        } elseif (is_string($roles)) {
            $firstRole = $roles;
        }

        $role = $firstRole ?: '—';

        $avatarUrl = asset('build/images/users/avatar-1.jpg');

        return [
            'raw' => $data,
            'user' => $user,
            'id' => $user['id'] ?? null,
            'name' => $name,
            'email' => $user['email'] ?? null,
            'role' => $role,
            'roles' => is_array($roles) ? $roles : [$roles],
            'permissions' => $data['permissions'] ?? [],
            'avatarUrl' => $avatarUrl,
        ];
    }
}
