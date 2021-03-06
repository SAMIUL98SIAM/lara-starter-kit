<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Module;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.roles.index');
        $data['roles'] = Role::all();
        return view('backend.roles.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.roles.create');
        $data['modules'] = Module::all();
        return view('backend.roles.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.roles.index');
        $this->validate($request,[
            'name'=> 'required|unique:roles',
            'permissions'=>'required|array',
            'permissions.*'=>'integer',
        ]);
        Role::create([
            'name'=> $request->name ,
            'slug'=> Str::slug($request->name),
        ])->permissions()->sync($request->input('permissions'),[]);
        notify()->success('User Successfully Added.', 'Added');
        return redirect()->route('app.roles.index')->with('success','Role Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        Gate::authorize('app.roles.edit');
        // Gate::authrize('app.roles.edit');
        $data['modules'] = Module::all();
        return view('backend.roles.form',compact('role'),$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize('app.roles.edit');
        $role->update([
            'name'=> $request->name ,
            'slug'=> Str::slug($request->name),
        ]);
        $role->permissions()->sync($request->input('permissions'));
        notify()->success('Role Successfully Updated.', 'Updated');
        return redirect()->route('app.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Gate::authorize('app.roles.destroy');
        if ($role->deletable) {
            $role->delete();
            notify()->error('Role Deleted','Success');
            return redirect()->back();
        } else {
            notify()->error('Role Can not deletable','Success');
            return redirect()->back();
        }

    }
}
