<?php

if (!function_exists('menu')) {

    /**
     * description
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
