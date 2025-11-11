<?php

return [
  'trialbtn' => 'Intenta',
  'errors' => [
    'max_allowed_services' => 'El cupo de servicios en prueba ha sido superado. Vuelve más tarde.',
    'max_services' => 'Ya has alcanzado el límite de prueba(s) gratuita(s) para este servicio.',
  ],
  'invoice' => [
    'name' => 'Intento de oferta',
    'description' => 'Período de prueba de la oferta :product (:start-:end).',
  ],
  'config' => [
    'total_now' => 'Total a pagar ahora',
    'total_after_trial' => 'Total a pagar después de la prueba',
    'start' => 'Comenzar',
    'title' => 'Comienza tu ensayo',
    'period' => 'Período',
    'details' => 'Podrá realizar su pago hasta :days días después de que termine su período de prueba, de acuerdo con las condiciones aplicables. Tendrá la opción de cancelar la prueba en cualquier momento.',
    'want_trial' => '¿Quieres probar el producto antes de comprarlo?',
    'can_trial' => 'Puede probar el producto durante :days días.',
  ],
  'service' => [
    'free' => [
      'title' => 'Renovar su servicio de prueba',
      'subheading' => 'Puedes renovar tu servicio de prueba hasta el :date antes de que sea cancelado el :date2.',
    ],
    'trial' => [
      'title' => 'Mejorar su servicio de prueba',
      'subheading' => 'Puedes mejorar tu servicio de prueba hasta el :date antes de que sea cancelado el :date2.',
    ],
    'simple' => [
        'title' => 'Prueba simple',
        'subheading' => 'Puedes probar el servicio hasta el :date sin ninguna obligación.',
    ],
  ],
  'admin' => [
    'config' => [
      'current_allowed_services' => 'Nombre actual de ensayos en curso',
      'max_allowed_services' => 'Número máximo de intentos en curso',
      'title' => 'Configuración de las pruebas gratuitas',
      'subheading' => 'Configura tus productos de prueba gratuita.',
      'max_services' => 'Número máximo de intentos por cliente',
      'trial_days' => 'Nombre de días de la prueba',
      'trial_durations' => 'Duración de la prueba',
      'current_trials' => 'Ensayos en curso',
      'trials_done' => 'Ensayos realizados',
      'trials_success' => 'Ensayos concluyentes',
      'show_on_card' => 'Mostrar el badge en la página de los planes',
      'trials_in_progress' => 'Activos / Máx',
      'success_rate' => 'Concluyentes / Total',
      'days' => 'días',
      'help' => '0 para desactivar',
      'force_label' => 'Tipo de ensayo',
      'types' => [
        'trial' => 'Ensayo para mejora',
        'free' => 'Prueba gratuita',
        'simple' => 'Prueba simple',
      ],
      'force' => [
        'yes' => 'Los clientes serán forzados a la prueba',
        'no' => 'Los clientes podrán pedir o solicitar una prueba',
      ],
      'create' => [
        'title' => 'Añadir un producto de prueba',
        'subheading' => 'Añadir un producto de prueba.',
      ],
      'show' => [
        'title' => 'Modificación de un producto de prueba',
        'subheading' => 'Puede modificar los parámetros de prueba.',
        'successfully' => 'Ensayo concluyente',
        'table_title' => 'Lista de servicios de prueba',
      ],
    ],
  ],
];
