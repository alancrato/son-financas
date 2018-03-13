<?php
declare(strict_types=1);

namespace SONFin\Plugins;

use Psr\Container\ContainerInterface;
use SONFin\ServiceContainerInterface;
use SONFin\View\ViewRender;

class ViewPlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
       $container->addLazy('twig', function (ContainerInterface $container){
           $loader = new \Twig_Loader_Filesystem(__DIR__ .'/../../template');
           $twig = new \Twig_Environment($loader);
           return $twig;
       });

       $container->addLazy('view.renderer', function (ContainerInterface $container){
           $twigEnvironment = $container->get('twig');
           return new ViewRender($twigEnvironment);
       });

    }
}