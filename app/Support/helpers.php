<?php

if (! function_exists('can')) {
    /**
     * Valida 1 permiso contra session('api_user.permissions')
     */
    function can(string $permission): bool
    {
        $perms = session('api_user.permissions', []);

        if (! is_array($perms)) {
            return false;
        }

        return in_array($permission, $perms, true);
    }
}

if (! function_exists('canAny')) {
    /**
     * true si tiene AL MENOS uno de los permisos
     */
    function canAny(array $permissions): bool
    {
        $perms = session('api_user.permissions', []);
        if (! is_array($perms)) {
            return false;
        }

        foreach ($permissions as $p) {
            if (in_array($p, $perms, true)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('canAll')) {
    /**
     * true si tiene TODOS los permisos
     */
    function canAll(array $permissions): bool
    {
        $perms = session('api_user.permissions', []);
        if (! is_array($perms)) {
            return false;
        }

        foreach ($permissions as $p) {
            if (! in_array($p, $perms, true)) {
                return false;
            }
        }

        return true;
    }
}
