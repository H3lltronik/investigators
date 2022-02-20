<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormReqRequest;
use App\Models\Financial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = $request->search;
        $request = Financial::orderBy('id', 'desc')
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('address', 'LIKE', "%$search%")
            ->orWhere('bank', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->paginate(6);

        

        return Inertia::render('Request/Request', [
            'can' => [
                'admin.request.create' => Auth::user()->can('admin.request.show'),
            ],
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $entity = User::find( $request->id );
        $users = User::orderBy('id', 'desc')->where('email', '!=', 'esau.egs1@gmail.com')->get();
        $roles = Role::where('name', '!=', 'SUPER ADMIN')->get();

        return Inertia::render('Request/Create', [
            'can' => [
                'admin.request.create' => Auth::user()->can('admin.request.create'),
            ],
            'entity' => $entity,
            'roles' => $roles,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormReqRequest $request) {
        $entity = Financial::firstOrCreate(['id' => $request->id]);
        $entity->name = $request->get('name');
        $entity->address = $request->get('address');
        $entity->bank = $request->get('bank');
        $entity->description = $request->get('description');
        $entity->user_id = $request->get('user_id');

        $entity->save();
        return redirect()->route('request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $entity = Financial::find($id);
        $users = User::orderBy('id', 'desc')->where('email', '!=', 'esau.egs1@gmail.com')->get();

        return Inertia::render('Request/Create', [
            'can' => [
                'admin.request.show' => Auth::user()->can('admin.request.show'),
            ],
            'entity' => $entity,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, StoreFormReqRequest $request) {
        $entity = Financial::find(['id' => $id]);
        $entity->name = $request->get('name');
        $entity->address = $request->get('address');
        $entity->bank = $request->get('bank');
        $entity->description = $request->get('description');
        $entity->user_id = $request->get('user_id');

        $entity->save();
        
        return redirect()->route('request.index')->with('success', 'Editado correctamente');
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
        Financial::destroy($id);

        return redirect()->route('request.index')->with('success', 'Borrado correctamente');

    }
}
