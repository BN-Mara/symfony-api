<?php


namespace App\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

final class MenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $child = $menu->addChild('maps', [
            'label' => 'Mapview',
            'route' => 'app_map_view',
        ])->setExtras([
            'icon' => 'fa fa-map-marker', // html is also supported
        ]);
        $menu->addChild('transactions',[
            'label' => 'Tranasction',
            'route' => 'app_admin_chart',
        ])->setExtras([
            'icon' => 'fa fa-money', // html is also supported
        ]);
    }
}