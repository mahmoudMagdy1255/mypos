@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>

                <li><a href="{{ route('dashboard.users.index') }}" class="fa fa-users"> @lang('site.users')</a></li>

                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

        	<div class="box box-primary">

        		<div class="box-header">
        			<h3 class="box-title">@lang('site.edit')</h3>
        		</div>

        		<div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.users.update' , $user->id) }}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">

                            <label>@lang('site.first_name')</label>
                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name}}">

                        </div>


                        <div class="form-group">

                            <label>@lang('site.last_name')</label>
                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">

                        </div>


                        <div class="form-group">

                            <label>@lang('site.email')</label>
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}">

                        </div>



                        <div class="form-group">

                            <label>@lang('site.image')</label>
                            <input type="file" class="form-control image" name="image">

                        </div>

                        <div class="form-group">

                            <img style="width: 100px;" class="img-thumbnail image-preview" src="{{$user->image_path }}">

                        </div>


                         <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products' , 'clients' , 'orders'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach ($models as $index=>$model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{ $model }}" data-toggle="tab">@lang('site.' . $model)</a></li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">

                                    @foreach ($models as $index=>$model)

                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">

                                            @foreach ($maps as $map)
                                                <label><input {{ $user->hasPermission($map . '-' . $model) ? 'checked' : '' }}  type="checkbox" name="permissions[]" value="{{ $map . '-' . $model }}"> @lang('site.' . $map)</label>
                                            @endforeach

                                        </div>

                                    @endforeach

                                </div><!-- end of tab content -->

                            </div><!-- end of nav tabs -->

                        </div>



                        <div class="form-group">

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-edit"></i>@lang('site.edit')
                            </button>

                        </div>

                    </form>

        		</div>

        	</div>

        </section><!-- end of content -->

</div><!-- end of content wrapper -->


@endsection