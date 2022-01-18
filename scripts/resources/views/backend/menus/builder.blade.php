@extends('layouts.backend.app')

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
                   @foreach ($menu->menuItems as $item)
                   <li>
                    @if ($item->type == 'divider')
                    <strong>{{$item->divider_title}}</strong>
                    @else
                    <span>{{$item->title}}</span>
                    @endif

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


                   </li>

                   @endforeach
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('js')
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
@endpush

