<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'goalioforgotpassword_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/goalioforgotpassword'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'GoalioForgotPassword\Entity'  => 'goalioforgotpassword_entity'
                )
            )
        )
    ),
);
