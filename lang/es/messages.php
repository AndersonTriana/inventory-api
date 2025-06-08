<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom Messages
    |--------------------------------------------------------------------------
    |
    | Custom messages for the application
    |
    */

    // Validation messages
    'validation' => [
        'category_name_unique' => 'Ya existe una categoría con este nombre.',
        'product_name_unique' => 'Ya existe un producto con este nombre.',
    ],

    // Success messages
    'success' => [
        'user_registered' => 'Usuario registrado exitosamente.',
        'login_successful' => 'Inicio de sesión exitoso.',
        'logout_successful' => 'Cierre de sesión exitoso.',
        'product_deleted' => 'Producto eliminado exitosamente.',
        'category_deleted' => 'Categoría eliminada exitosamente.',
    ],

    // Stock status
    'stock' => [
        'in_stock' => 'En stock',
        'low_stock' => 'Stock bajo',
        'out_of_stock' => 'Sin stock',
    ],

    // User roles
    'roles' => [
        'admin' => 'Administrador',
        'user' => 'Usuario',
    ],
];
