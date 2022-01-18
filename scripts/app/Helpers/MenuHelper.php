<?php

if (!function_exists('menu')) {

    /**
     * Get menu with items & childs by name
     *
     * @param
     * @return
     */
    function menu($name)
    {
        $menu = \App\Models\Menu::where('name',$name)->first();
        return $menu->menuItems()->with('childs')->get();
    }
}
