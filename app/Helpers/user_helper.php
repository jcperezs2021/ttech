<?php

namespace App\Helpers;

use CodeIgniter\Config\Services;

if (!function_exists('get_user_data')) {
    /**
     * Obtiene datos del objeto de usuario almacenado en la sesión.
     *
     * @param string $key La clave del dato dentro del objeto de usuario.
     * @return mixed El valor almacenado en la sesión o null si no existe.
     */
    function get_user_data($key)
    {
        $session = Services::session();
        $user = $session->get('user'); // Obtén el objeto de usuario de la sesión
        return $user ? ($user->$key ?? null) : null; // Devuelve el valor o null si no existe
    }
}
