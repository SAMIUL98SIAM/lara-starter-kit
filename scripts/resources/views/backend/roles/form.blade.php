@extends('layouts.backend.app')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-check icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div><div>{{ isset($role) ? 'Edit' : 'Create New' }} Role</div></div>
        </div>
        <div class="page-title-actions">
            <a href="{{route('app.roles.index')}}" type="button" class="btn-shadow mr-3 btn btn-primary"><i class="fas fa-backspace"></i> Back to list</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <form method="POST" action="{{isset($role)?route('app.roles.update',$role->id):route('app.roles.store')}}">
            @csrf
            @isset($role)
                @method('PUT')
            @endisset
            <div class="card-body">
                <h5 class="card-title">Manage Role</h5>

                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $role->name ?? old('name') }}" autofocus>
                    @error('name')
                    <p class="p-2">
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </p>
                    @enderror
                </div>

                <div class="text-center">
                    <strong>Manage permissions for role</strong>
                    @error('permissions')
                    <p class="p-2">
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    </p>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" onClick="toggle(this)" id="select-all">
                        <label class="custom-control-label" for="select-all">Select All</label>
                    </div>
                </div>
                @forelse($modules->chunk(2) as $key => $chunks)
                    <div class="form-row">
                        @foreach($chunks as $key=>$module)
                            <div class="col">
                                <h5>Module: {{ $module->name }}</h5>
                                @foreach($module->permissions as $key=>$permission)
                                    <div class="mb-3 ml-4">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="permission-{{ $permission->id }}"
                                                   value="{{ $permission->id }}"
                                                   name="permissions[]"
                                            @if(isset($role))
                                                @foreach($role->permissions as $rPermission){{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                                @endforeach
                                            @endif
                                            >
                                            <label class="custom-control-label"for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="row">
                        <div class="col text-center">
                            <strong>No Module Found.</strong>
                        </div>
                    </div>
                @endforelse
                <button type="submit" class="btn btn-primary">
                    @isset($role)
                    <i class="fas fa-arrow-circle-up"></i>
                    <span>Update</span>
                    @else
                    <i class="fas fa-plus-circle"></i>
                    <span>Store</span>
                    @endisset

                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
       function toggle(source) {
            checkboxes = document.getElementsByName('permissions[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endpush

