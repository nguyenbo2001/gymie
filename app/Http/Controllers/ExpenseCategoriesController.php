<?php

namespace App\Http\Controllers;

use Auth;
use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoriesController extends Controller
{
    /**
     * init function
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::paginate(10);
        $expenseCategoriesTotal = ExpenseCategory::all();
        $count = $expenseCategoriesTotal->count();

        return view('expenseCategories.index', compact('expenseCategories', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenseCategories.create');
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
            'name' => 'unique:expenses_categories,name'
        ]);

        $expenseCategory = new ExpenseCategory($request->all());

        $expenseCategory->createdBy()->associate(Auth::user());
        $expenseCategory->updatedBy()->associate(Auth::user());

        $expenseCategory->save();
        flash()->success('Expense Category was successfully added');

        return redirect('expenses/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);

        return view('expenseCategories.edit', compact('expenseCategory'));
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
        $expenseCategory = ExpenseCategory::findOrFail($id);

        $expenseCategory->update($request->all());
        $expenseCategory->updatedBy()->associate(Auth::user());
        $expenseCategory->save();

        flash()->success('Category was successfully updated');

        return redirect('expenses/categories');
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

    public function archive($id, Request $request) {
        ExpenseCategory::destroy($id);

        return redirect('expenses/categories');
    }
}
