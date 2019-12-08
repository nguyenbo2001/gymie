<?php

namespace App\Http\Controllers;

use Auth;
use App\Followup;
use Illuminate\Http\Request;

class FollowupsController extends Controller
{
    /**
     * init
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Store followup
     */
    public function store(Request $request) {
        $followup = new Followup($request->all());

        $followup->createdBy()->associate(Auth::user());
        $followup->updatedBy()->associate(Auth::user());
        $followup->enquiry_id = $request->enquiry_id;
        $followup->save();

        flash()->success('Follow Up was successfully created');
        return redirect(action('EnquiriesController@shoe', ['id' => $request->enquiry_id]))
    }

    /**
     * Update followup
     */
    public function(Request $request, $id) {
        $followup = Followup::findOrFail($id);
        $followup->update($request->all());
        $followup->createdBy()->associate(Auth::user());
        $followup->save();

        flash()->success('Follow Up details were successfully updated');

        return redirect(action('EnquiriesController@show', ['id' => $request->enquiry_id]));
    }
}
