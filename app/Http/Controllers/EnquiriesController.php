<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Member;
use App\Enquiry;
use App\Followup;
use App\SmsTrigger;
use Illuminate\Http\Request;

class EnquiriesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $inquiries = Enquiry::indexQuery($request->sort_field,
                                        $request->sort_direction,
                                        $request->drp_start,
                                        $request->drp_end)
                            ->search('"'.$request->input('search').'"')
                            ->paginate(10);
        $enquiriesTotal = Enquiry::indexQuery($request->sort_field,
                                            $request->sort_direction,
                                            $request->drp_start,
                                            $request->drp_end)
                                ->search('"'. $request->input('search').'"')
                                ->get();
        $count = $enquiriesTotal->count();

        if ( ! $request->has('drp_start') or ! $request->has('drp_end')) {
            $drp_placeholder = 'Select daterange filter';
        } else {
            $drp_placeholder = $request->drp_start. " - ". $request->drp_end;
        }

        $request->flash();

        return view('enquiries.index', compact('enquiries', 'count', 'drp_placeholder'));
    }

    public function show($id) {
        $enquiry = Enquiry::findOrFail($id);

        $followups = $enquiry->followups->sortByDesc('updated_at');

        return view('enquiries.show', compact('enquiry', 'followups'));
    }

    public function create() {
        return view('enquiries.create');
    }

    public function store(Request $request) {
        // unique values check
        $this->validate($request, [
            'email' => 'unique:enquiries,email',
            'contact' => 'unique:enquiries,contact'
        ]);
    }
}
