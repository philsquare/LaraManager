<?php namespace PhilMareu\Laramanager\Http\Controllers;

use PhilMareu\Laramanager\Http\Requests\CreateSettingRequest;
use PhilMareu\Laramanager\Http\Requests\UpdateSettingRequest;
use PhilMareu\Laramanager\Models\LaramanagerSetting;

class SettingsController extends Controller {

    protected $setting;

    public function __construct(LaramanagerSetting $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        $settings = $this->setting->all();

        return view('laramanager::settings.index', compact('settings'));
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function show()
    {

    }

    public function edit($settingId)
    {
        $setting = $this->setting->findOrFail($settingId);

        return view('laramanager::settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request, $settingId)
    {
        $setting = $this->setting->findOrFail($settingId);
        $setting->update($request->only('value'));

        return redirect('admin/settings');
    }

    public function destroy()
    {

    }
}