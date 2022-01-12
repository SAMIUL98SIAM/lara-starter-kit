@extends('layouts.backend.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('backend/css/datatable.css')}}">
@endpush


@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-check icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Roles</div>
        </div>
        <div class="page-title-actions">
            <a href="{{route('app.roles.create')}}" type="button" class="btn-shadow mr-3 btn btn-primary"><i class="fa fa-plus"></i> Create Role</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="table-responsive">
                <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Permission</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key=>$role)
                        <tr>
                            <td class="text-center text-muted">{{$key}}</td>
                            <td class="text-center">{{$role->name}}</td>
                            <td class="text-center">
                                @if ($role->permissions->count() > 0)
                                <span><div class="badge badge-info">{{$role->permissions->count()}}</div></span>
                                @else
                                <span><div class="badge badge-danger">No Permission Found : (</div></span>
                                @endif
                            </td>
                            <td class="text-center">{{$role->created_at->diffForHumans()}}</td>
                            <td class="text-center">
                                <a href="{{route('app.roles.edit',$role->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"><span> Edit</span></i></a>

                                @if ($role->deletable == true)
                                        <button type="button" class="btn btn-danger btn-sm"onclick="deleteData({{ $role->id }})"><i class="fas fa-trash-alt"></i><span>Delete</span></button>
                                         <form id="delete-form-{{ $role->id }}"
                                        action="{{ route('app.roles.destroy',$role->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Datatable -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#datatable').DataTable();
    } );
</script>

<!-- Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
