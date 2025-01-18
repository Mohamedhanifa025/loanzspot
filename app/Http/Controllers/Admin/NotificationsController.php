<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;

class NotificationsController extends Controller
{
  public function index(Request $request)
  {
      $notifications = new Notification;

      if ($request->has('term') && $request->term != '') {
          $notifications = $notifications->where('title', 'LIKE', "%$request->term%")
              ->orWhereHas('user', function ($query) use($request) {
                    $query->where('users.name', 'LIKE', "%$request->term%");
              });
      }

      $notifications = $notifications->orderBy('id', 'desc')->get();

      return view('admin.notifications.index' , compact('notifications'));
  }
  public function create()
  {
      abort_unless(\Gate::allows('notification_create'), 403);

      return view('admin.notifications.create');
  }

  public function store(Request $request)
  {

      $notification = Notification::create($request->all());

      return redirect()->route('admin.notifications.index');
  }

  public function edit(Notification $notification)
  {
      abort_unless(\Gate::allows('notification_edit'), 403);

      return view('admin.notifications.edit', compact('notification'));
  }

  public function update(Request $request, Notification $notification)
  {
      abort_unless(\Gate::allows('notification_edit'), 403);

      $notification->update($request->all());

      return redirect()->route('admin.notifications.index');
  }

  public function show(Notification $notification)
  {
      abort_unless(\Gate::allows('notification_show'), 403);

      return view('admin.notifications.show', compact('notification'));
  }

  public function destroy(Notification $notification)
  {
      abort_unless(\Gate::allows('notification_delete'), 403);

      $notification->delete();

      return back();
  }

  public function massDestroy(Request $request)
  {
    Notification::whereIn('id', request('ids'))->delete();

      return response(null, 204);
  }
}
