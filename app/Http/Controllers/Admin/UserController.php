<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = $request->search;
        $users = User::orderBy('id', 'desc')
            ->where('email', '!=', 'esau.egs1@gmail.com')
            ->orWhere('name', 'LIKE', "%$search%")
            ->orWhere('email', 'LIKE', "%$search%")
            ->paginate(6);

        return Inertia::render('Users/Users', [
            'can' => [
                'admin.users.create' => Auth::user()->can('admin.users.show'),
            ],
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $entity = User::find( $request->id );
        $roles = Role::where('name', '!=', 'SUPER ADMIN')->get();

        return Inertia::render('Users/Create', [
            'can' => [
                'admin.users.create' => Auth::user()->can('admin.users.create'),
            ],
            'entity' => $entity,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request) {
        $entity = User::firstOrCreate(['id' => $request->id]);
        $entity->name = $request->get('name');
        $entity->email = $request->get('email');
        $entity->phone = $request->get('phone');
        $entity->address = $request->get('address');
        $entity->password = $request->get('password');

        $entity->save();

        foreach ($request->userRoles as $role) {
            $entity->assignRole($role);
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $entity = User::find($id);
        $roles = Role::where('name', '!=', 'SUPER ADMIN')->get();
        $entity['userRoles'] = array_map(function ($role) {
            return $role['name'];
        }, $entity->roles->toArray() );

        return Inertia::render('Users/Create', [
            'can' => [
                'admin.users.show' => Auth::user()->can('admin.users.show'),
            ],
            'entity' => $entity,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, StoreUserRequest $request) {
        $entity = User::find($id);
        $entity->name = $request->get('name');
        $entity->email = $request->get('email');
        $entity->phone = $request->get('phone');
        $entity->address = $request->get('address');
        $entity->password = $request->get('password');

        foreach ($request->roles as $role) {
            $entity->assignRole($role);
        }

        return redirect()->route('users.index')->with('success', 'Editado correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        User::destroy($id);

        return redirect()->route('users.index')->with('success', 'Borrado correctamente');

    }
}
