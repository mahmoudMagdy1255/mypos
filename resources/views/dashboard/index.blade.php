@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.dashboard')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>
            </ol>
        </section>

        <section class="content">

        </section><!-- end of content -->

</div><!-- end of content wrapper -->


@endsection
