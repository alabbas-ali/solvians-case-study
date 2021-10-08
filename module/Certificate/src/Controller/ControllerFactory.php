<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Certificate\Controller;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;


class ControllerFactory implements FactoryInterface {
    
    /**
     * @param ContainerInterface $serviceManager
     * @param string $controllerName
     * @param array|null|null $options
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when creating a service.
     * @throws ContainerException if any other error occurs
     * @return mixed
     */
    public function __invoke(ContainerInterface $serviceManager, $controllerName, array $options = null) {
        if(!class_exists($controllerName)) {
            throw new ServiceNotFoundException("Requested controller name '".$controllerName."' does not exist.");
        }
        $entity_manager = $serviceManager->get('doctrine.entitymanager.orm_default');
        return new $controllerName($entity_manager);
    }
}
