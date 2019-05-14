<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Image;
use Storage;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function __construct() {
		$this->middleware(['permission:read-users'])->only('index');
		$this->middleware(['permission:create-users'])->only('create');
		$this->middleware(['permission:update-users'])->only('edit');
		$this->middleware(['permission:delete-users'])->only('destroy');
	}

	public function index(Request $request) {

		$users = User::whereRoleIs('admin')->where(function ($query) use ($request) {

			return $query->when($request->search, function ($q) use ($request) {

				return $q->where('first_name', 'like', '%' . $request->search . '%')
					->orWhere('last_name', 'like', '%' . $request->search . '%');

			});

		})->latest()->paginate(5);

		return view('dashboard.users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('dashboard.users.create')->with('title', trans('site.add_user'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$data = $request->validate([

			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|confirmed',
			'image' => 'image',
			'permissions' => 'required',
		]);

		$data['password'] = bcrypt($data['password']);

		if ($request->image) {

			$image = Image::make($request->image)->resize(300, null, function ($constraint) {

				$constraint->aspectRatio();

			})->save(public_path('uploads/user_images/' . $request->image->hashName()));

			$data['image'] = $request->image->hashName();
		}

		$user = User::create($data);

		$user->attachRole('admin');

		$user->syncPermissions($request->permissions);

		session()->flash('success', trans('site.added_successfully'));

		return redirect()->route('dashboard.users.index');

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user) {

		return view('dashboard.users.edit', compact('user'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		$data = $request->validate([

			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email|unique:users,email,' . $user->id,
			'image' => 'image',
			'permissions' => 'required',
		]);

		if ($request->image) {

			if ($user->image != 'default.png') {

				Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
			}

			$image = Image::make($request->image)->resize(300, null, function ($constraint) {

				$constraint->aspectRatio();

			})->save(public_path('uploads/user_images/' . $request->image->hashName()));

			$data['image'] = $request->image->hashName();
		}

		$user->update($data);

		$user->syncPermissions($request->permissions);

		session()->flash('success', trans('site.updated_successfully'));

		return redirect()->route('dashboard.users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user) {

		if ($user->image != 'default.png') {

			Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
		}

		$user->delete();

		session()->flash('success', trans('site.deleted_successfully'));

		return redirect()->route('dashboard.users.index');

	}
}
