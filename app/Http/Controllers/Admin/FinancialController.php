<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinancialsRequest;
use App\Models\Financial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = $request->search;
        $financials = Financial::orderBy('id', 'desc')
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('address', 'LIKE', "%$search%")
            ->orWhere('bank', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->paginate(6);

        

        return Inertia::render('Financials/Financials', [
            'can' => [
                'admin.financials.create' => Auth::user()->can('admin.financials.show'),
            ],
            'financials' => $financials,
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

        return Inertia::render('Financials/Create', [
            'can' => [
                'admin.financials.create' => Auth::user()->can('admin.financials.create'),
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
    public function store(StoreFinancialsRequest $request) {
        $entity = Financial::firstOrCreate(['id' => $request->id]);
        $entity->name = $request->get('name');
        $entity->address = $request->get('address');
        $entity->bank = $request->get('bank');
        $entity->description = $request->get('description');
        $entity->user_id = $request->get('user_id');

        $entity->save();
        return redirect()->route('financials.index');
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

        return Inertia::render('Financials/Create', [
            'can' => [
                'admin.financials.show' => Auth::user()->can('admin.financials.show'),
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
    public function edit($id, StoreFinancialsRequest $request) {
        $entity = Financial::find(['id' => $id]);
        $entity->name = $request->get('name');
        $entity->address = $request->get('address');
        $entity->bank = $request->get('bank');
        $entity->description = $request->get('description');
        $entity->user_id = $request->get('user_id');

        $entity->save();
        
        return redirect()->route('financials.index')->with('success', 'Editado correctamente');
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

        return redirect()->route('financials.index')->with('success', 'Borrado correctamente');

    }
}
