@extends('layouts.backend.app')

@push('css')
<link rel="stylesheet" href="{{asset('backend/nestable/css/jquery.nestable.css')}}">
<link rel="stylesheet" href="{{asset('backend/nestable/css/jquery.nestable.scss')}}">

<style>
.pull-right{
    margin-top: 10px;
    margin-left: 5px;

}
</style>

@endpush

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-menu icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Menu Builder ({{$menu->name}})</div>
        </div>
        <div class="page-title-actions">
            <a href="{{route('app.menus.index')}}" type="button" class="btn-shadow mr-3 btn btn-primary"><i class="fas fa-backspace"></i> Back to list</a>

            <a href="{{ route('app.menus.item.create',$menu->id) }}" type="button" class="btn-shadow mr-3 btn btn-success"><i class="fas fa-plus-circle"></i> Crete Menu Item</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {{-- how to use callout --}}
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">How To Use:</h5>
                <p>You can output a menu anywhere on your site by calling <code>menu('name')</code></p>
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-body menu-builder">
                <h5 class="card-title">Drag and drop the menu Items below to re-arrange them.</h5>
                <div class="dd">
                    <ol class="dd-list">
                        @foreach ($menu->menuItems as $item)
                            <li class="dd-item" data-id="{{$item->id}}">
                                <div class="pull-right item-actions">
                                    <a class="btn btn-info btn-sm" href="{{ route('app.menus.item.edit',['id'=>$menu->id,'itemId'=>$item->id]) }}"><i
                                        class="fas fa-edit"></i>
                                    <span>Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $item->id }})"><i class="fas fa-trash-alt"></i><span>Delete</span></button>
                                    <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('app.menus.item.destroy',['id'=>$menu->id,'itemId'=>$item->id]) }}" method="POST"
                                    style="display: none;">
                                    @csrf()
                                    @method('DELETE')
                                </form>
                                </div>


                                <div class="dd-handle">
                                    @if ($item->type == 'divider')
                                    <strong><b style="color: red">Divider:</b> {{$item->divider_title}}</strong>
                                    @else
                                    <span><b style="color: green">Item:</b> {{$item->title}}</span>
                                    @endif
                                </div>

                                @if (!$item->childs->isEmpty())
                                    <ol class="dd-list">
                                        @foreach ($item->childs as $childItem)
                                        <li class="dd-item" data-id="{{$childItem->id}}">
                                            <div class="pull-right item-actions">
                                                <a class="btn btn-info btn-sm" href="{{ route('app.menus.item.edit',['id'=>$menu->id,'itemId'=>$childItem->id]) }}"><i
                                                    class="fas fa-edit"></i>
                                                <span>Edit</span>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $childItem->id }})"><i class="fas fa-trash-alt"></i><span>Delete</span></button>
                                                <form id="delete-form-{{ $childItem->id }}"
                                                action="{{ route('app.menus.item.destroy',['id'=>$menu->id,'itemId'=>$childItem->id]) }}" method="POST"
                                                style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                            </div>

                                            <div class="dd-handle">
                                                @if ($childItem->type == 'divider')
                                                <strong><b style="color: red">Divider:</b> {{$childItem->divider_title}}</strong>
                                                @else
                                                <span><b style="color: green">Item:</b> {{$childItem->title}}</span>
                                                @endif
                                            </div>
                                        </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('js')
    <!-- Nestable js --->
    <script src="{{asset('backend/nestable/js/jquery.nestable.js')}}"></script>

    <!-- Dropify -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e)
                {
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('.dd').nestable({maxDepth: 2});

            $('.dd').on('change', function (e) {
                $.post('{{ route('app.menus.order',$menu->id) }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Successfully updated menu order.',
                    });
                });
            });
        });
    </script>
@endpush

