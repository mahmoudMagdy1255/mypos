@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}" class="fa fa-dashboard"> @lang('site.dashboard')</a></li>

                <li><a href="{{ route('dashboard.products.index') }}" class="fa fa-products"> @lang('site.products')</a></li>

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

                    <form action="{{ route('dashboard.products.update' , $product->id) }}" enctype="multipart/form-data" method="POST">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">

                            <label>@lang('site.all_categories')</label>

                            <select class="form-control" name="category_id">


                                <option value=""> @lang('site.all_categories') </option>

                                @foreach( $categories as $category )

                                    <option {{ $product->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->name }} </option>

                                @endforeach


                            </select>

                        </div>


                        @foreach( config('translatable.locales') as $lang )

                            <div class="form-group">

                                <label> @lang('site.' . $lang . '.name' ) </label>
                                <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ $product->translate($lang)->name }}">

                                <label> @lang('site.' . $lang . '.description' ) </label>
                                <textarea class="form-control ckeditor" name="{{ $lang }}[description]">
                                    {{ $product->translate($lang)->description }}
                                </textarea>


                            </div>

                        @endforeach

                         <div class="form-group">

                            <label>@lang('site.image')</label>
                            <input type="file" class="form-control image" name="image">

                        </div>

                        <div class="form-group">

                            <img style="width: 100px;" class="img-thumbnail image-preview" src="{{ $product->image_path }}">

                        </div>

                         <div class="form-group">

                            <label>@lang('site.purchase_price')</label>
                            <input type="number" value="{{ $product->purchase_price }}" class="form-control" name="purchase_price">

                        </div>

                        <div class="form-group">

                            <label>@lang('site.sale_price')</label>
                            <input type="number" class="form-control" value="{{ $product->sale_price }}" name="sale_price">

                        </div>

                        <div class="form-group">

                            <label>@lang('site.stock')</label>
                            <input type="number" value="{{ $product->stock }}" class="form-control" name="stock">

                        </div>


                        <div class="form-group">

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i>@lang('site.edit')
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section><!-- end of content -->

</div><!-- end of content wrapper -->


@endsection