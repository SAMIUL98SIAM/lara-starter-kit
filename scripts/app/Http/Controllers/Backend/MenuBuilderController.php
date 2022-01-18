<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class MenuBuilderController extends Controller
{
    /**
     * Display the menu Builder
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        Gate::authorize('app.menus.index');
        $menu = Menu::findOrFail($id);
        return view('backend.menus.builder',compact('menu'));
    }

    /**
     * Create new menu item
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemCreate($id)
    {
        Gate::authorize('app.menus.create');
        $menu = Menu::findOrFail($id);
        return view('backend.menus.item.form',compact('menu'));
    }

     /**
     * Store new menu item
     * @param StoreMenuItemRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemStore(Request $request, $id)
    {
        $this->validate($request,[
            'divider_title' => 'nullable|string',
            'title' => 'nullable|string',
            'url' => 'nullable|string',
            'target' => 'nullable|string',
            'icon_class' => 'nullable|string',
        ]);

        $menu = Menu::findOrFail($id);
        MenuItem::create([
            'menu_id' => $menu->id,
            'type' => $request->type,
            'title' => $request->title,
            'divider_title' => $request->divider_title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon_class
        ]);
        notify()->success('Menu Item Successfully Added.', 'Added');
        return redirect()->route('app.menus.builder',$menu->id);
    }


    /**
     * Edit menu item
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemEdit($menuId, $itemId)
    {
        Gate::authorize('app.menus.edit');
        $menu = Menu::findOrFail($menuId);
        $menuItem = $menu->menuItems()->findOrFail($itemId);
        return view('backend.menus.item.form',compact('menu','menuItem'));
    }

    /**
     * Update menu item
     * @param Request $request
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function itemUpdate(Request $request, $menuId, $itemId)
    {
        $this->validate($request,[
            'divider_title' => 'nullable|string',
            'title' => 'nullable|string',
            'url' => 'nullable|string',
            'target' => 'nullable|string',
            'icon_class' => 'nullable|string',
        ]);


        $menu = Menu::findOrFail($menuId);
        $menu->menuItems()->findOrFail($itemId)->update([
            'type' => $request->type,
            'title' => $request->title,
            'divider_title' => $request->divider_title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon_class
        ]);
        notify()->success('Menu Item Successfully Updated.', 'Updated');
        return redirect()->route('app.menus.builder',$menu->id);
    }

    /**
     * Delete a menu item
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemDestroy($menuId, $itemId)
    {
        Gate::authorize('app.menus.destroy');
        Menu::findOrFail($menuId)
            ->menuItems()
            ->findOrFail($itemId)
            ->delete();
        notify()->success('Menu Item Successfully Deleted.', 'Deleted');
        return redirect()->back();
    }

}
