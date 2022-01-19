<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::updateOrCreate([
            'name' => 'backend-sidebar',
            'description' => 'This is backend sidebar',
            'deletable' => false]);

        MenuItem::updateOrCreate([
            'menu_id' => $menu->id,
            'type' => 'divider',
            'parent_id' => null,
            'order' => 1,
            'divider_title' => 'Menus'
        ]);

        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 2,
            'title' => 'Dashboard',
            'url' => "/app/dashboard",
            'icon_class' => 'metismenu-icon pe-7s-rocket'
        ]);


        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 3,
            'title' => 'Pages',
            'url' => "/app/pages",
            'icon_class' => 'metismenu-icon pe-7s-news-paper'
        ]);



        MenuItem::updateOrCreate([
            'menu_id' => $menu->id,
            'type' => 'divider',
            'parent_id' => null,
            'order' => 4,
            'divider_title' => 'Access Control'
        ]);


        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 5,
            'title' => 'Roles',
            'url' => "/app/roles",
            'icon_class' => 'metismenu-icon pe-7s-check'
        ]);


        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 6,
            'title' => 'Users',
            'url' => "/app/users",
            'icon_class' => 'metismenu-icon pe-7s-users'
        ]);


        MenuItem::updateOrCreate([
            'menu_id' => $menu->id,
            'type' => 'divider',
            'parent_id' => null,
            'order' => 7,
            'divider_title' => 'System'
        ]);

        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 8,
            'title' => 'Menus',
            'url' => "/app/menus",
            'icon_class' => 'metismenu-icon pe-7s-menus'
        ]);

        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 9,
            'title' => 'Backups',
            'url' => "/app/backups",
            'icon_class' => 'metismenu-icon pe-7s-cloud'
        ]);

        $menu->menuItems()->updateOrCreate([
            'type' => 'item',
            'parent_id' => null,
            'order' => 10,
            'title' => 'Settings',
            'url' => "/app/settings",
            'icon_class' => 'metismenu-icon pe-7s-settings'
        ]);


    }
}
