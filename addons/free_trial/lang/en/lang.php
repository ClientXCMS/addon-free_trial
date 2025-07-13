<?php

return [
  'trialbtn' => 'Try',
  'errors' => [
    'max_allowed_services' => 'The quota of services in trial is exceeded. Please come back later.',
    'max_services' => 'You have already reached the free trial quota for this service.',
  ],
  'invoice' => [
    'name' => 'Offer attempt',
    'description' => 'Trial period of offer :product (:start-:end).',
  ],
  'config' => [
    'total_now' => 'Total to pay now',
    'total_after_trial' => 'Total to pay after the trial',
    'start' => 'start',
    'title' => 'Start your trial',
    'period' => 'period',
    'details' => 'You will be able to make your payment up to :days days after the end of your trial period, in accordance with the applicable terms. You will have the option to cancel the trial at any time.',
    'want_trial' => 'Do you want to test the product before buying it?',
    'can_trial' => 'You can test the product for :days days.',
  ],
  'service' => [
    'free' => [
      'title' => 'Renew your trial service',
      'subheading' => 'You can renew your trial service until :date before it is canceled on :date2.',
    ],
    'trial' => [
      'title' => 'Improve your trial service',
      'subheading' => 'You can improve your trial service until :date before it is cancelled on :date2.',
    ],
  ],
  'admin' => [
    'config' => [
      'current_allowed_services' => 'Current number of trials in progress',
      'max_allowed_services' => 'Maximum number of attempts in progress',
      'title' => 'Configuration of free trials',
      'subheading' => 'Set up your free trial products.',
      'max_services' => 'Maximum number of attempts per client',
      'trial_days' => 'Number of days of the trial',
      'current_trials' => 'Ongoing tests',
      'trials_done' => 'Tests carried out',
      'trials_success' => 'Conclusive tests',
      'help' => '0 to deactivate',
      'force_label' => 'Type of test',
      'types' => [
        'trial' => 'Essay for improvement',
        'free' => 'Free trial',
      ],
      'force' => [
        'yes' => 'Customers will be forced to trial.',
        'no' => 'Customers will be able to order or request a trial.',
      ],
      'create' => [
        'title' => 'Addition of a trial product',
        'subheading' => 'Adding a trial product.',
      ],
      'show' => [
        'title' => 'Modification of a test product',
        'subheading' => 'You can modify the trial settings.',
        'successfully' => 'Successful trial',
        'table_title' => 'List of testing services',
      ],
    ],
  ],
];
