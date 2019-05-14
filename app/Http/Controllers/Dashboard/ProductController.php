<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Image;

class ProductController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$products = Product::where(function ($query) {

			return $query->when(request()->search, function ($q) {

				return $q->whereTranslationLike('name', '%' . request()->search . '%');

			});
		})->where(function ($query) {

			return $query->when(request()->category_id, function ($q) {

				return $q->where('category_id', request()->category_id);

			});

		})->latest()->paginate(5);

		$categories = Category::all();

		return view('dashboard.products.index', compact('products', 'categories'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		$categories = Category::all();

		return view('dashboard.products.create', compact('categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$rules = [];

		$rules += [
			'category_id' => 'required',
			'purchase_price' => 'required',
			'sale_price' => 'required',
			'stock' => 'required',
		];

		foreach (config('translatable.locales') as $lang):

			$rules += [$lang . '.*' => 'required'];
			$rules += [$lang . '.name' => Rule::unique('product_translations', 'name')];
			$rules += [$lang . '.description' => Rule::unique('product_translations', 'description')];

		endforeach;

		$data = request()->validate($rules);

		if ($request->image) {

			$image = Image::make($request->image)->resize(300, null, function ($constraint) {

				$constraint->aspectRatio();

			})->save(public_path('uploads/product_images/' . $request->image->hashName()));

			$data['image'] = $request->image->hashName();
		}

		Product::create($data);

		session()->flash('success', trans('site.added_successfully'));

		return redirect()->route('dashboard.products.index');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Product $product) {

		$categories = Category::all();

		return view('dashboard.products.edit', compact('product', 'categories'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Product $product) {

		$rules = [];

		$rules += [
			'category_id' => 'required',
			'purchase_price' => 'required',
			'sale_price' => 'required',
			'stock' => 'required',
		];

		foreach (config('translatable.locales') as $lang):

			$rules += [$lang . '.*' => 'required'];
			$rules += [$lang . '.name' => Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')];
			$rules += [$lang . '.description' => Rule::unique('product_translations', 'description')->ignore($product->id, 'product_id')];

		endforeach;

		$data = request()->validate($rules);

		if ($request->image) {

			if ($product->image != 'default.png') {

				Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
			}

			$image = Image::make($request->image)->resize(300, null, function ($constraint) {

				$constraint->aspectRatio();

			})->save(public_path('uploads/product_images/' . $request->image->hashName()));

			$data['image'] = $request->image->hashName();
		}

		$product->update($data);

		session()->flash('success', trans('site.updated_successfully'));

		return redirect()->route('dashboard.products.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Product $product) {

		if ($product->image != 'default.png') {

			Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
		}

		$product->delete();

		session()->flash('success', trans('site.deleted_successfully'));

		return redirect()->route('dashboard.products.index');

	}
}
