@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.categories') </li>
            </ol>
        </section>

        <section class="content">

			<div class="box box-primary">

        		<div class="box-header with-border">
        			<h3 class="box-title" style="margin-bottom: 15px">
                    @lang('site.categories')  <small>{{ $categories->total() }}</small>
                </h3>


                    <form class="" action="{{ route('dashboard.categories.index') }}" method="GET">

                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i> @lang('site.search')</button>

                                @if( auth()->user()->hasPermission('create-categories') )

                                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else

                                    <a href="#" class="btn disabled btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>

                                @endif

                            </div>

                        </div>

                    </form>

                </div>

        		 <div class="box-body">

                    @if ($categories->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.product_count')</th>
                                <th>@lang('site.related_product')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($categories as $index=>$category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products->count() }}</td>

                                    <td> <a href="{{ route('dashboard.products.index' , [ 'category_id' => $category->id ] ) }}" class="btn btn-info btn-sm">@lang('site.related_product')</a> </td>


                                    <td>

                                        @if( auth()->user()->hasPermission('update-categories') )

                                    	<a class="btn btn-info btn-sm" href="{{ route('dashboard.categories.edit' , $category->id) }}"> <i class="fa fa-edit"></i> @lang('site.edit')</a>

                                        @else

                                            <a class="btn btn-info disabled btn-sm" href="#" > <i class="fa fa-edit"></i> @lang('site.edit')</a>

                                        @endif

                                        @if( auth()->user()->hasPermission('delete-categories') )

                                            <form style="display:inline" action="{{ route('dashboard.categories.destroy' , $category->id) }}" method="POST">
                                        		{{ csrf_field() }}
                                        		{{ method_field('DELETE') }}


                                        		<button class="btn btn-danger delete btn-sm"  type="submit" > <i class="fa fa-trash"></i> @lang('site.delete')</button>


                                        	</form>

                                        @else

                                            <button class="btn btn-danger disabled"> <i class="fa fa-trash"></i> @lang('site.delete')</button>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        {{ $categories->appends( request()->query() )->links() }}

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


        	</div>
        </section><!-- end of content -->

</div><!-- end of content wrapper -->

@endsection