<?php

return [
    'management' => [
        'clinic' => [
            'title' => 'Clinic',
            'icon' => 'fa fa-stethoscope',
            'sub' => [
                'branches' => [
                    'title' => 'branches',
                    'url' => 'management/clinic_branches',
                    'icon' => 'fa fa-h-square'
                ],
                'specifications' => [
                    'title' => 'specifications',
                    'url' => 'management/clinic_specifications',
                    'icon' => 'fa fa-medkit'
                ],
                'doctors' => [
                    'title' => 'doctors',
                    'url' => 'management/clinic_doctors',
                    'icon' => 'fa fa-user-md'
                ],
                'patients' => [
                    'title' => 'patients',
                    'url' => 'management/clinic_patients',
                    'icon' => 'fa-wheelchair'
                ],
                'disease_templates' => [
                    'title' => 'disease_templates',
                    'url' => 'management/clinic_disease_templates',
                    'icon' => 'fa fa-heartbeat'
                ],
                'reservations' => [
                    'title' => 'reservations',
                    'url' => 'management/clinic_reservations',
                    'icon' => 'fa fa-hospital-o'
                ],
                'reservation_types' => [
                    'title' => 'reservation_types',
                    'url' => 'management/clinic_doctor_reservation_types',
                    'icon' => 'fa-sitemap'
                ],
            ],
            'doctor_reviews' => [
                'title' => 'doctor_reviews',
                'url' => 'management/clinic_doctor_reviews',
                'icon' => 'fa fa-star-half-o'
            ],
        ],
    ],
];

/*
 * 'clinic_reservations' => array(
                    'title' => 'clinic_reservations',
                    'icon' => 'fa fa-hospital-o',
                    'sub' => array(
                        'clinic_reservations' => array(
                            'title' => 'clinic_reservations',
                            'url' => 'management/clinic_reservations',
                            'icon' => 'fa fa-hospital-o'
                        ),
                        'clinic_doctor_reservation_types' => array(
                            'title' => 'reservation_types',
                            'url' => 'management/clinic_doctor_reservation_types',
                            'icon' => 'fa-sitemap'
                        ),
                    ),
                ),
 */