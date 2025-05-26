<?php

return [
    'orders' => [
        'label' => 'Import Orders',
        'permission' => 'import-orders',
        'files' => ['orders.xslx'],
        'headers_to_db' => [
            'OrderID' => 'order_id',
            'CustomerName' => 'customer_name',
            'Amount' => 'amount',
        ],
        'validation' => [
            'OrderID' => ['required', 'unique:orders,order_id'],
            'CustomerName' => ['required', 'string'],
            'Amount' => ['required', 'numeric'],
        ],
        'update_or_create' => ['match' => ['order_id']],
    ],
    'customers' => [
        'label'            => 'Import Customers',
        'permission'       => 'import-customers',
        'files'            => ['customers.xlsx'],
        'headers_to_db'    => [
            'CustomerID'   => 'customer_id',
            'Name'         => 'name',
            'Email'        => 'email',
        ],
        'validation'       => [
            'CustomerID'   => ['required','unique:customers,customer_id'],
            'Name'         => ['required','string'],
            'Email'        => ['required','email','unique:customers,email'],
        ],
        'update_or_create' => ['match' => ['customer_id']],
    ],
    'invoices' => [
        'label'            => 'Import Invoices',
        'permission'       => 'import-invoices',
        'files'            => ['invoices_part1.csv','invoices_part2.csv'],
        'headers_to_db'    => [
            'InvoiceID'    => 'invoice_id',
            'OrderID'      => 'order_id',
            'Total'        => 'total',
        ],
        'validation'       => [
            'InvoiceID'    => ['required','unique:invoices,invoice_id'],
            'OrderID'      => ['required','exists:orders,order_id'],
            'Total'        => ['required','numeric'],
        ],
        'update_or_create' => ['match' => ['invoice_id']],
    ],
];
