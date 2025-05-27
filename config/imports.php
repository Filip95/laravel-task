<?php

return [
    'orders' => [
        'label'            => 'Import Orders',
        'permission'       => 'import-orders',
        'files'            => ['orders.xlsx', 'orders.csv'],
        'headers_to_db'    => [
            'orderid'      => 'order_id',
            'customername' => 'customer_name',
            'amount'       => 'amount',
        ],
        'validation'       => [
            'orderid'      => ['required', 'unique:orders,order_id'],
            'customername' => ['required', 'string'],
            'amount'       => ['required', 'numeric'],
        ],
        'update_or_create' => ['match' => ['order_id']],
    ],

    'customers' => [
        'label'            => 'Import Customers',
        'permission'       => 'import-customers',
        'files'            => ['customers.xlsx', 'customers.csv'],
        'headers_to_db'    => [
            'customerid'   => 'customer_id',
            'name'         => 'name',
            'email'        => 'email',
        ],
        'validation'       => [
            'customerid'   => ['required', 'unique:customers,customer_id'],
            'name'         => ['required', 'string'],
            'email'        => ['required', 'email', 'unique:customers,email'],
        ],
        'update_or_create' => ['match' => ['customer_id']],
    ],

    'invoices' => [
        'label'            => 'Import Invoices',
        'permission'       => 'import-invoices',
        'files'            => ['invoices_part1.csv', 'invoices_part2.csv', 'invoices.xlsx'],
        'headers_to_db'    => [
            'invoiceid'    => 'invoice_id',
            'orderid'      => 'order_id',
            'total'        => 'total',
        ],
        'validation'       => [
            'invoiceid'    => ['required', 'unique:invoices,invoice_id'],
            'orderid'      => ['required', 'exists:orders,order_id'],
            'total'        => ['required', 'numeric'],
        ],
        'update_or_create' => ['match' => ['invoice_id']],
    ],
];
