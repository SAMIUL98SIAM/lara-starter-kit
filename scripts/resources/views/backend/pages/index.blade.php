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
                <i class="pe-7s-news-paper icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Pages</div>
        </div>
        <div class="page-title-actions">
            <a href="{{route('app.pages.create')}}" type="button" class="btn-shadow mr-3 btn btn-primary"><i class="fa fa-plus"></i> Create Page</a>
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
                            <th class="text-center">Title</th>
                            <th class="text-center">URL</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Last Modified</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $key=>$page)
                            <tr>
                                <td class="text-center text-muted">#{{ $key + 1 }}</td>
                                <td>{{$page->title}}</td>
                                <td class="text-center">
                                    <a href="{{ route('page',$page->slug) }}" target="_blank">
                                        {{ $page->slug }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if ($page->status == true)
                                        <div class="badge badge-success">Active</div>
                                    @else
                                        <div class="badge badge-danger">Inactive</div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $page->updated_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('app.pages.edit',$page->id) }}"><i
                                            class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteData({{ $page->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete</span>
                                    </button>
                                    <form id="delete-form-{{ $page->id }}"
                                          action="{{ route('app.pages.destroy',$page->id) }}" method="POST"
                                          style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
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
