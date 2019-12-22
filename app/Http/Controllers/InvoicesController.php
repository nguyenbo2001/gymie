<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use JavaScript;
use App\Invoice;
use App\Service;
use Carbon\Carbon;
use App\Subscription;
use App\ChequeDetail;
use App\InvoiceDetail;
use App\PaymentDetail;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Init middleware
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Function index
     */
    public function index(Request $request) {
        $invoices = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'.$request->input('search').'"')
                            ->paginate(10);
        $invoicesTotal = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'.$request->input('search').'"')
                            ->get();
        $count = $invoicesTotal->count();

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start . ' - ' . $request->drp_end;
        }

        $request->flash();

        return view('invoices.index', compact('invoices', 'count', 'drp_placeholder'));
    }

    /**
     * Function Unpaid
     */
    public function unpaid(Request $request) {
        $invoices = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 0)
                            ->paginate(10);
        $invoicesTotal = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 0)
                            ->get();
        $count = $invoicesTotal->count();

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start . ' - ' . $request->drp_end;
        }

        $request->flash();

        return view('invoices.unpaid', compact('invoices', 'count', 'drp_placeholder'));
    }

    /**
     * Function Paid
     */
    public function paid(Request $request) {
        $invoices = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 1)
                            ->paginate(10);
        $invoicesTotal = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 1)
                            ->get();
        $count = $invoicesTotal->count();

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start . ' - ' . $request->drp_end;
        }

        $request->flash();

        return view('invoices.paid', compact('invoices', 'count', 'drp_placeholder'));
    }

    /**
     * Function Partial
     */
    public function partial(Request $request) {
        $invoices = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 2)
                            ->paginate(10);
        $invoicesTotal = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 2)
                            ->get();
        $count = $invoicesTotal->count();

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start . ' - ' . $request->drp_end;
        }

        $request->flash();

        return view('invoices.partial', compact('invoices', 'count', 'drp_placeholder'));
    }

    /**
     * Function Overpaid
     */
    public function overpaid(Request $request) {
        $invoices = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 3)
                            ->paginate(10);
        $invoicesTotal = Invoice::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'. $request->input('search'). '"')
                            ->where('invoices.status', 3)
                            ->get();
        $count = $invoicesTotal->count();

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start . ' - ' . $request->drp_end;
        }

        $request->flash();

        return view('invoices.overpaid', compact('invoices', 'count', 'drp_placeholder'));
    }

    /**
     * FUnction show
     */
    public function show($id) {
        $invoice = Invoice::findOrFail($id);
        $settings = \Utilities::getSettings();

        return view('invoices.show', compact('invoice', 'settings'));
    }

    /**
     * Function Create Payment
     */
    public function createPayment(Request $request, $id) {
        $invoice = Invoice::findOrFail($id);

        return view('payments.create', compact('invoice'));
    }

    /**
     * Function Delete
     */
    public function delete($id) {
        DB::beginTransaction();

        try {
            InvoiceDetail::where('invoice_id', $id)->delete();
            $payment_details = PaymentDetail::where('invoice_id', $id)->get();

            foreach ($payment_details as $payment_detail) {
                ChequeDetail::where('payment_id', $payment_detail->id)->delete();
                $payment_detail->delete();
            }

            Subscription::where('invoice_id', $id)->delete();
            Invoice::destroy($id);

            DB::commit();

            return back();
        } catch(\Exception $e) {
            DB::rollback();

            return back();
        }
    }

    /**
     * FUnction Discount
     * @param Invoice $id
     */
    public function discount($id) {
        $invoice = Invoice::findOrFail($id);

        JavaScript::put([
            'taxes' => \Utilities::getSetting('taxes'),
            'gymieToday' => Carbon::today()->format('Y-m-d'),
            'servicesCount' => Service::count(),
        ]);

        return view('invoices.discount', compact('invoice'));
    }

    /**
     * Function Apply Discount
     * @param Invoice $id
     */
    public function applyDiscount(Request $request, $id) {
        DB::beginTransaction();

        try {
            $invoice_total = $request->admission_amount +
                            $request->subscription_amount +
                            $request->taxes_amount -
                            $request->discount_amount;
            $already_paid = PaymentDetail::leftJoin('cheque_details',
                                                    'payment_details.id',
                                                    '=',
                                                    'cheque_details.payment_id')
                                        ->whereRaw("payment_details.invoice_id = $id AND (cheque_details.`status` = 2 or cheque_details.`status` IS NULL)")
                                        ->sum('payment_details.payment_amount');

            $pending = $invoice_total - $already_paid;
            $status = \Utilities::setInvoiceStatus($pending, $invoice_total);

            Invoice::where('id', $id)
                    ->update([
                        'invoice_number' => $request->invoice_number,
                        'total' => $status,
                        'pending_amount' => $request->pending,
                        'discount_amount' => $request->discount_amount,
                        'discount_percent' => $request->discount_percent,
                        'discount_note' => $request->discount_note,
                        'tax' => $request->taxes_amount,
                        'additional_fees' => $request->additional_fees,
                        'note' => ' ',
                    ]);

            DB::commit();
            flash()->success('Discount was successfully updated');

            return redirect(action('InvoicesController@show', ['id' => $id]));
        } catch(\Exception $e) {
            DB::rollback();
            flash()->error('Error while updating discount. Please try again');

            return back();
        }
    }
}
