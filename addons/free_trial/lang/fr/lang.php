<?php

return [
    'trialbtn' => 'Essayez',
    'errors' => [
        'max_allowed_services' => 'Le quota de services en cours d\'essai est dépassé. Revenez plus tard.',
        'max_services' => 'Vous avez déjà atteint le quota d\'essai(s) gratuit(s) pour ce service.',
    ],
    'invoice' => [
        'name' => 'Essai d\'offre',
        'description' => 'Période d\'essai d\'offre :product (:start-:end).',
    ],
    'config' => [
        'total_now' => 'Total à payer maintenant',
        'total_after_trial' => 'Total à payer après l\'essai',
        'start' => 'Commencer',
        'title' => 'Commencez votre essai',
        'period' => 'Période',
        'details' => 'Vous pourrez effectuer votre paiement jusqu\'à :days jours après la fin de votre période d\'essai, conformément aux conditions applicables. Vous aurez la possibilité d\'annuler l\'essai à tout moment.',
        'want_trial' => 'Vous voulez tester le produit avant de l\'acheter ?',
        'can_trial' => 'Vous pouvez tester le produit pendant :days jours.',
    ],
    'service' => [
        'free' => [
            'title' => 'Renouveler votre service d\'essai',
            'subheading' => 'Vous pouvez renouveler votre service d\'essai jusqu\'au :date avant qu\'il soit annulé le :date2.',
        ],
        'trial' => [
            'title' => 'Améliorer votre service d\'essai',
            'subheading' => 'Vous pouvez améliorer votre service d\'essai jusqu\'au :date avant qu\'il soit annulé le :date2.',
        ],
    ],
    'admin' => [
        'config' => [
            'current_allowed_services' => 'Nombre actuel d\'essais en cours',
            'max_allowed_services' => 'Nombre maximum d\'essais en cours',
            'title' => 'Configuration des essais gratuits',
            'subheading' => 'Configurez vos produits d\'essai gratuit.',
            'max_services' => 'Nombre d\'essais maximum par client',
            'trial_days' => 'Nombre de jours de l\'essai',
            'current_trials' => 'Essais en cours',

            'trials_done' => 'Essais effectués',
            'trials_success' => 'Essais concluants',

            'help' => '0 pour désactiver',
            'force_label' => 'Type d\'essai',
            'types' => [
                'trial' => 'Essai pour amélioration',
                'free' => 'Essai gratuit',
            ],
            'force' => [
                'yes' => 'Les clients seront forcés à l\'essai',
                'no' => 'Les clients pourront commander ou demander un essai',
            ],
            'create' => [
                'title' => 'Ajout d\'un produit d\'essai',
                'subheading' => 'Ajout d\'un produit d\'essai.',
            ],
            'show' => [
                'title' => 'Modification d\'un produit d\'essai',
                'subheading' => 'Vous pouvez modifier les paramètres d\'essai.',
                'successfully' => 'Essai concluant',
                'table_title' => 'Liste des services d\'essai',
            ],
        ],

    ],
];
