@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.products') </li>
            </ol>
        </section>

        <section class="content">

			<div class="box box-primary">

        		<div class="box-header with-border">
        			<h3 class="box-title" style="margin-bottom: 15px">
                    @lang('site.products')  <small>{{ $products->total() }}</small>
                </h3>


                    <form class="" action="{{ route('dashboard.products.index') }}" method="GET">

                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">

                                <select class="form-control" name="category_id">

                                    <option value=""> @lang('site.all_categories') </option>

                                    @foreach( $categories as $category )

                                        <option {{ request()->category_id == $category->id ? 'selected' : '' }} {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->name }} </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i> @lang('site.search')</button>

                                @if( auth()->user()->hasPermission('create-products') )

                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else

                                    <a href="#" class="btn disabled btn-primary"> <i class="fa fa-plus"></i> @lang('site.add')</a>

                                @endif

                            </div>


                        </div>

                    </form>

                </div>

        		 <div class="box-body">

                    @if ($products->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.category')</th>
                                <th> @lang('site.image') </th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.profite_percent')</th>

                                <th>@lang('site.stock')</th>

                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($products as $index=>$product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{  $product->category->name  }}</td>
                                    <td><img class="img-thumbnail" src="{{ $product->image_path }}" width="100px" height="100px" > </td>
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ $product->profite_percent }} %</td>
                                    <td>{{ $product->stock }}</td>


                                    <td>

                                        @if( auth()->user()->hasPermission('update-products') )

                                    	<a class="btn btn-info btn-sm" href="{{ route('dashboard.products.edit' , $product->id) }}"> <i class="fa fa-edit"></i> @lang('site.edit')</a>

                                        @else

                                            <a class="btn btn-info disabled btn-sm" href="#" > <i class="fa fa-edit"></i> @lang('site.edit')</a>

                                        @endif

                                        @if( auth()->user()->hasPermission('delete-products') )

                                            <form style="display:inline" action="{{ route('dashboard.products.destroy' , $product->id) }}" method="POST">
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

                        {{ $products->appends( request()->query() )->links() }}

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


        	</div>
        </section><!-- end of content -->

</div><!-- end of content wrapper -->

@endsection