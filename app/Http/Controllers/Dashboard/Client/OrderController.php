<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Client $client) {

		$categories = Category::with('products')->get();

		return view('dashboard.clients.orders.create', compact('client', 'categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function show(Client $client, Order $Order) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Client $client, Order $Order) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Client $client, Order $Order) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Client $client, Order $Order) {
		//
	}
}
