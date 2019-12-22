<?php

namespace App\Http\Controllers;

use Auth;
use App\Expense;
use Carbon\Carbon;
use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpensesController extends Controller
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
    public function index(Request $request)
    {
        $expenses = Expense::indexQuery($request->category_id,
                                        $request->sort_field, $request->sort_direction,
                                        $request->drp_start, $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->paginate(10);
        $expenseTotal = Expense::indexQuery($request->category_id,
                                            $request->sort_field, $request->sort_direction,
                                            $request->drp_start, $request->drp_end)
                                ->search('"'. $request->input('search'). '"')
                                ->get();
        $count = $expenseTotal->sum('amount');

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start . ' - ' . $request->drp_end;
        }

        $request->flash();

        return view('expenses.index', compact('expenses', 'count', 'drp_placeholder'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrExpenseCategories = array();
        $expenseCategories = ExpenseCategory::where('status', '=', '1')->get(['id', 'name'])->toArray();
        foreach ($expenseCategories as $expenseCategory) {
            $arrExpenseCategories[$expenseCategory['id']] = $expenseCategory['name'];
        }
        return view('expenses.create', compact('arrExpenseCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expenseData = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'due_date' => $request->due_date,
            'repeat' => $request->repeat,
            'note' => $request->note,
            'amount' => $request->amount,
        ];

        $expense = new Expense($expenseData);
        $expense->createdBy()->associate(Auth::user());
        $expense->updatedBy()->associate(Auth::user());
        $expense->save();

        if ($request->due_date <= Carbon::today()->format('Y-m-d')) {
            $expense->paid = \constPaymentStatus::Paid;
        } else {
            $expense->paid = \constPaymentStatus::Unpaid;
        }
        $expense->createdBy()->associate(Auth::user());
        $expense->save();

        flash()->success('Expense was successfully added');
        return redirect('expenses/all');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenses = Expense::findOrFail($id);

        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arrExpenseCategories = array();
        $expenseCategories = ExpenseCategory::where('status', '=', '1')->get(['id', 'name'])->toArray();
        foreach ($expenseCategories as $expenseCategory) {
            $arrExpenseCategories[$expenseCategory['id']] = $expenseCategory['name'];
        }

        $expense = Expense::findOrFail($id);

        return view('expenses.edit', compact('expense', 'arrExpenseCategories'));
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
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());

        if ($request->due_date == Carbon::today()) {
            $expense->paid = \constPaymentStatus::Paid;
        } elseif ($request->due_date != Carbon::today()
                && $expense->paid == \constPaymentStatus::Paid) {
            $expense->paid = \constPaymentStatus::Paid;
        } else {
            $expense->paid = \constPaymentStatus::Unpaid;
        }

        $expense->updatedBy()->associate(Auth::user());
        $expense->save();

        flash()->success('Expense was successfully updated');

        return redirect('expenses/all');
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

    public function paid(Request $request, $id) {
        Expense::where('id', '=', $id)
                ->update(['paid' => \constPaymentStatus::Paid]);

        flash()->success('Expense was successfully paid');
        return redirect('expenses/all');
    }

    public function delete($id) {
        Expense::destroy($id);

        return redirect('expenses/all');
    }
}
