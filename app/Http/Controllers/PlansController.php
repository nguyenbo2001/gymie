<?php

namespace App\Http\Controllers;

use Auth;
use App\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plans = Plan::excludeArchive()->search('"'. $request->input('search'). '"')
                    ->paginate(10);
        $planTotal = Plan::excludeArchive()->search('"'.$request->input('search').'"')
                        ->get();
        $count = $planTotal->count();

        return view('plans.index', compact('plans', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plans.create');
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
            'plan_code' => 'unique:plans,plan_code',
            'plan_name' => 'unique:plans,plan_name',
            'service_id' => 'required',
        ]);

        $plan = new Plan($request->all());
        $plan->createdBy()->associate(Auth::user());
        $plan->updatedBy()->associate(Auth::user());
        $plan->save();

        flash()->success('Plan was successfully created');
        return redirect('plans');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = Plan::findOrFail($id);

        return view('plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);

        return view('plans.edit', compact('plan'));
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
        $plan = Plan::findOrFail($id);
        $plan->update($request->all());
        $plan->updatedBy()->associate(Auth::user());
        $plan->save();

        flash()->success('Plan details were successfully updated');

        return redirect('plans/all');
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

    public function archive($id) {
        Plan::destroy($id);

        return redirect('plans/all');
    }
}
