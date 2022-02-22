<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormReqRequest;
use App\Models\Address;
use App\Models\ExtendedQuestion;
use App\Models\Financial;
use App\Models\Request;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HttpRequest $request)
    {
        $search = $request->search;
        $query = Request::select('*')->has('user')->with(['user' => function ($innerQuery) {
            return $innerQuery->orderBy('id', 'ASC');
        }]);

        if (Auth::user()->isAdmin()) {
        } else {
        }
        $requests = $query->paginate(6);

        return Inertia::render('Request/Request', [
            'can' => Auth::user()->getAllUserPermissions(),
            'requests' => $requests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(HttpRequest $request)
    {
        $entity = User::find($request->id);

        if (Auth::user()->isAdmin()) {
            $financials = Financial::all();
        } else {
            $financials = Auth::user()->financials()->get();
        }

        return Inertia::render('Request/Create', [
            'can' => Auth::user()->getAllUserPermissions(),
            'isAdmin' => Auth::user()->isAdmin(),
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
    public function store(StoreFormReqRequest $request)
    {
        $entity = Request::firstOrCreate(['id' => $request->id]);
        $entity->financial_id = $request->get('financial_id');
        $addresses = $request->get('addresses');
        // return dump(count($addresses));
        $entity->save();

        foreach ($addresses as $key => $address) {
            $addressEntity = Address::firstOrCreate(['id' => $address['id'] ?? null]);
            $addressEntity->request_id = $entity->id;

            $addressEntity->name = $address['name'];
            $addressEntity->city = $address['city'];
            $addressEntity->phone = $address['phone'];
            $addressEntity->address = $address['address'];
            $addressEntity->hasExtendedQuestions = $address['hasExtendedQuestions'];
            $addressEntity->save();
            if (filter_var($address['hasExtendedQuestions'], FILTER_VALIDATE_BOOLEAN)) {
                foreach ($address['extended_questions'] as $key => $extendedQuestion) {
                    $questionEntity = ExtendedQuestion::firstOrCreate(['id' => $extendedQuestion['id'] ?? null]);
                    $questionEntity->name = $extendedQuestion['name'];
                    $questionEntity->type = $extendedQuestion['type'];
                    $questionEntity->address_id = $addressEntity->id;
                    $questionEntity->save();
                }
            }
        }

        return redirect()->route('request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = Request::find($id)->with(['addresses' => function ($innerQuery) {
            return $innerQuery->with(['extendedQuestions']);
        }])->get();
        $financials = Auth::user()->financials()->get();

        return Inertia::render('Request/Create', [
            'can' => Auth::user()->getAllUserPermissions(),
            'entity' => $entity[0],
            'financials' => $financials,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, StoreFormReqRequest $request)
    {
        $entity = Request::find(['id' => $id]);

        return redirect()->route('request.index')->with('success', 'Editado correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HttpRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Request::destroy($id);

        return redirect()->route('requests.index')->with('success', 'Borrado correctamente');
    }

    public function evaluate($id)
    {
        $entity = Request::with([
            'financial' => function ($query) {
                $query->with('user');
            },
            'addresses' => function ($query) {
                $query->with('extendedQuestions');
            },
            'task',
        ])->where('id', '=', $id)->get();
        $task = Tasks::where('request_id', '=', $id)->get();
        $promoters = User::whereHas("roles", function ($q) {
            $q->where("name", "role.promoter");
        })->get();

        return Inertia::render('Request/Assign', [
            'can' => Auth::user()->getAllUserPermissions(),
            'entity' => $entity[0],
            'promoters' => $promoters,
            'task' => $task[0],
        ]);
    }

    public function assign(HttpRequest $request)
    {
        return dump($request);
        $task = Tasks::firstOrCreate([
            'id' => $request->task_id,
            'user_id' => $request->promoter_id,
            'request_id' => $request->request_id,
        ]);

        return redirect()->route('request.index')->with('success', 'Asignado correctamente');
    }
}
