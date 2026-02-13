<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $settings = SiteSetting::first();
        if ($settings) {
            $settings->update($request->all());
        } else {
            SiteSetting::create($request->all());
        }

        return redirect()->route('admin.site-settings.edit')->with('success', 'Site settings updated successfully!');
    }
}
