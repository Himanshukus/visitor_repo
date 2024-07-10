<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data = Setting::all();
        $background = Setting::where('field_name', 'app_background')->first()->value ?? 'Select';
        
        return view('setting.index', compact('data', 'background'));
    }
    public function update(Request $request)
    {
        $fields = $request->input('fields', []);
        $background = $request->app_background;
        
        foreach ($fields as $field_name => $is_enabled) {
            $is_enabled_value = $is_enabled === 'on' ? 1 : 0;
            Setting::where('field_name', $field_name)->update(['is_enabled' => $is_enabled_value]);
        }

        Setting::where('field_name', 'app_background')->update(['value' => $background]);
       
        // Setting::updateOrCreate(
        //     ['field_name' => 'app_background'],
        //     ['value' => $background]
        // );
        return redirect()->route('setting')->with('sa-success', 'Settings updated successfully');
    }
}
