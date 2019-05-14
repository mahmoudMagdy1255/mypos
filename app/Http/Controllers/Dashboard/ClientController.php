<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$clients = Client::when(request('search'), function ($query) {

			return $query->where('name', 'like', '%' . request('search') . '%')
				->orWhere('phone', 'like', '%' . request('search') . '%')
				->orWhere('address', 'like', '%' . request('search') . '%');

		})->latest()->paginate();

		return view('dashboard.clients.index', compact('clients'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('dashboard.clients.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$data = request()->validate([

			'name' => 'required',
			'phone.0' => 'required',
			'address' => 'required',

		]);

		Client::create(request()->all());

		session()->flash('success', trans('site.added_successfully'));

		return redirect()->route('dashboard.clients.index');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function show(Client $client) {
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Client $client) {
		return view('dashboard.clients.edit', compact('client'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Client $client) {

		$data = request()->validate([

			'name' => 'required',
			'phone.0' => 'required',
			'address' => 'required',

		]);

		$client->update(request()->all());

		session()->flash('success', trans('site.updated_successfully'));

		return redirect()->route('dashboard.clients.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Client $client) {

		$client->delete();

		session()->flash('success', trans('site.deleted_successfully'));

		return redirect()->route('dashboard.products.index');

	}
}
