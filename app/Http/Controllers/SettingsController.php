<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Function Init
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $settings = \Utilities::getSettings();

        return view('settings.show', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $settings = \Utilities::getSettings();

        return view('settings.edit', compact('settings'));
    }

    public function save(Request $request) {
        // Get all input except _token to loop through and save
        $settings = $request->except('_token');

        // Update all settings
        foreach ($settings as $key => $value) {
            if ($key == 'gym_logo') {
                \Utilities::updateFile($request, '', $key, 'gym_logo', \constPaths::GymLogo);
                $value = $key.'.jpg';
            }

            Setting::where('key', '=', $key)->update(['value' => $value]);
        }

        flash()->success('Setting was successfully updated');
        return redirect('settings/edit');
    }
}
