<?php

namespace GoalioForgotPasswordDoctrineORM;

use Doctrine\ORM\Mapping\Driver\XmlDriver;
use ZfcUser\Module as ZfcUser;

class Module
{
    public function onBootstrap($e)
    {
        $app     = $e->getParam('application');
        $sm      = $app->getServiceManager();
        $options = $sm->get('goalioforgotpassword_module_options');

        // Add the default entity driver only if specified in configuration
        if ($options->getEnableDefaultEntities()) {
            $chain = $sm->get('doctrine.driver.orm_default');
            $chain->addDriver(new XmlDriver(__DIR__ . '/config/xml/goalioforgotpassworddoctrineorm'), 'GoalioForgotPasswordDoctrineORM\Entity');
        }
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'goalioforgotpassword_doctrine_em' => 'doctrine.entitymanager.orm_default',

            ),
            'factories' => array(
                'goalioforgotpassword_module_options' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Options\ModuleOptions(isset($config['goalioforgotpassword']) ? $config['goalioforgotpassword'] : array());
                },
                'goalioforgotpassword_password_mapper' => function ($sm) {
                    return new \GoalioForgotPasswordDoctrineORM\Mapper\Password(
                        $sm->get('goalioforgotpassword_doctrine_em'),
                        $sm->get('goalioforgotpassword_module_options')
                    );
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
