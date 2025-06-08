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
        'category_name_unique' => 'A category with this name already exists.',
        'product_name_unique' => 'A product with this name already exists.',
    ],

    // Success messages
    'success' => [
        'user_registered' => 'User registered successfully.',
        'login_successful' => 'Login successful.',
        'logout_successful' => 'Logout successful.',
        'product_deleted' => 'Product deleted successfully.',
        'category_deleted' => 'Category deleted successfully.',
    ],

    // Stock status
    'stock' => [
        'in_stock' => 'In stock',
        'low_stock' => 'Low stock',
        'out_of_stock' => 'Out of stock',
    ],

    // User roles
    'roles' => [
        'admin' => 'Administrator',
        'user' => 'User',
    ],
];
