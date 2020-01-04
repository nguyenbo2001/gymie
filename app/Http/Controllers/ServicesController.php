<?php

namespace App\Http\Controllers;

use Auth;
use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Function Init
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::search('"' . $request->input('search') . '"')
            ->paginate(10);
        $serviceTotal = Service::search('"' . $request->input('search') . '"')
            ->get();
        $count = $serviceTotal->count();

        return view('services.index', compact('services', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:services,name',
            'description' => 'required',
        ]);

        $service = new Service($request->all());
        $service->createdBy()->associate(Auth::user());
        $service->updatedBy()->associate(Auth::user());
        $service->save();

        flash()->success('Service was successfully created');
        return redirect('plans/services/all');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        $service->updatedBy()->associate(Auth::user());
        $service->save();

        flash()->success('Service details were successfully updated');
        return redirect('plans/services/all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        Service::destroy($id);
        return redirect('plans/services/all');
    }
}
