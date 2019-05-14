@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>

                <li><a href="{{ route('dashboard.clients.index') }}" class="fa fa-clients"> @lang('site.clients')</a></li>

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

                    <form action="{{ route('dashboard.clients.update' , $client->id) }}" method="POST">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">

                            <label> @lang('site.name' ) </label>

                             <input type="text" class="form-control" name="name" value="{{ $client->name }}">


                        </div>

                        @for($i = 0 ; $i < 2 ; $i++)


                            <div class="form-group">

                                <label> @lang('site.phone' ) </label>

                                 <input type="text" class="form-control" value="{{ $client->phone[$i] ?? '' }}" name="phone[]">


                            </div>

                        @endfor



                        <div class="form-group">

                            <label> @lang('site.address' ) </label>

                             <textarea class="form-control" name="address">
                                {{ $client->address }}
                             </textarea>


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