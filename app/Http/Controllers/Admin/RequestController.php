<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormReqRequest;
use App\Models\Financial;
use App\Models\Request;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
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
    public function index(HttpRequest $request) {
        $search = $request->search;
        $requests = Request::orderBy('id', 'desc');

        if ( Auth::user()->isAdmin() ) {
            
        } else {

        }
        $requests = $requests->paginate(6);
        

        return Inertia::render('Request/Request', [
            'can' => [
                'admin.requests.create' => Auth::user()->can('admin.requests.show'),
            ],
            'requests' => $requests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(HttpRequest $request) {
        $entity = User::find( $request->id );
        $financials = Auth::user()->financials()->get();

        return Inertia::render('Request/Create', [
            'can' => [
                'admin.requests.create' => Auth::user()->can('admin.requests.create'),
            ],
            'entity' => $entity,
            'financials' => $financials,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormReqRequest $request) {
        dump($request);
        // $entity = Financial::firstOrCreate(['id' => $request->id]);
        // $entity->name = $request->get('name');
        // $entity->address = $request->get('address');
        // $entity->bank = $request->get('bank');
        // $entity->description = $request->get('description');
        // $entity->user_id = $request->get('user_id');

        // $entity->save();
        return redirect()->route('requests.index');
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
                'admin.requests.show' => Auth::user()->can('admin.requests.show'),
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
        
        return redirect()->route('requests.index')->with('success', 'Editado correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HttpRequest $request, $id) {
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

        return redirect()->route('requests.index')->with('success', 'Borrado correctamente');

    }
}
