<?php
return [
  // Database configuration
  'database' => [

    'airports' => [
      'host'     => 'localhost',
      'port'     => 3306,
      'dbname'   => 'csv_db 7',
      'charset'  => 'utf8mb4'
    ],
  ],


  'users' => [
      'manager' => [
        'email'=> 'manager@manager.com',
        'password' => 'manager123',
        'permission' => 'manager'
      ],
      'employee' => [
        'email' => 'employee@employee.com',
        'password' => 'employee123',
        'permission' => 'employee'
      ],
      'teamleader' => [
        'email' => 'teamleader@teamleader.com',
        'password' => 'teamleader123',
        'permission' => 'teamleader'
      ]

  ],
];
?>