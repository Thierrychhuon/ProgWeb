<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('index', new Route('/index', array(
    '_controller' => 'TCPlatformBundle:Avert:index',
)));

return $collection;