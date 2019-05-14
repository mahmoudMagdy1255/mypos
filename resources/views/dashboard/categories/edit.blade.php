@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>

                <li><a href="{{ route('dashboard.categories.index') }}" class="fa fa-categories"> @lang('site.categories')</a></li>

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

                    <form action="{{ route('dashboard.categories.update' , $category->id) }}" method="POST">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        @foreach( config('translatable.locales') as $lang )

                            <div class="form-group">

                                <label> @lang('site.' . $lang . '.name' ) </label>




                                <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ $category->translate($lang)->name }}" required="">


                            </div>

                        @endforeach

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