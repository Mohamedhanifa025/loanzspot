<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{
  public function index()
  {
      $settingsRecord = Setting::all();
      $settings = array();
      foreach ($settingsRecord as $record) {
              $settings[$record['key']] = $record['value'];
      }
    return view('admin.settings.index' , compact('settings'));
  }
  public function create()
  {
      abort_unless(\Gate::allows('setting_create'), 403);

      return view('admin.settings.create');
  }

  public function store(Request $request)
  {
      $data = $request->all();
      $settings = array();
      $settings['smtp'] = ['smtp_host', 'smtp_port', 'smtp_username', 'smtp_password'];
      $settings['app'] = ['app_id', 'app_secret'];
      $settings['rewards'] = ['primary_reward_value', 'secondary_reward_value', 'territory_reward_value'];

      if($request->has('type') && isset($settings[$request->type])) {
          $update_settings = $settings[$request->type];
          foreach ($update_settings as $key => $value) {
              $setting = Setting::updateOrCreate(
                  [
                      "type" => $request->type,
                      "key" => $value
                  ],
                  [
                      "type" => $request->type,
                      "key" => $value,
                      'value' => $data[$value]
                  ]);
          }
      }

      return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
  }

  public function edit(Customer $customer)
  {
      abort_unless(\Gate::allows('setting_edit'), 403);

      return view('admin.settings.edit', compact('setting'));
  }

  public function update(Request $request, Setting $setting)
  {
      abort_unless(\Gate::allows('setting_edit'), 403);

      $setting->update($request->all());

      return redirect()->route('admin.settings.index');
  }

  public function show(Setting $setting)
  {
      abort_unless(\Gate::allows('setting_show'), 403);

      return view('admin.settings.show', compact('setting'));
  }

  public function destroy(Setting $setting)
  {
      abort_unless(\Gate::allows('setting_delete'), 403);

      $setting->delete();

      return back();
  }

  public function massDestroy(Request $request)
  {
    Setting::whereIn('id', request('ids'))->delete();

      return response(null, 204);
  }
}
