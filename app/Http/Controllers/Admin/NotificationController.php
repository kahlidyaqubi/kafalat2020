<?php

namespace App\Http\Controllers\Admin;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    //
    public function read($id)
    {
        $notfe=auth()->user()->unreadNotifications()->find($id);

        if($notfe)
            $notfe->markAsRead();

        return 'success';
    }

    public function index()
    {
        $user=auth()->user();
        $items = auth()->user()->notifications()->orderByDesc('created_at')->paginate(20);
        return view('admin.notifications.index', compact('items','user'));
    }

    public function delete($id)
    {

        $item = Notification::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/admin/notifications");
        }
        $item->delete();
        Session::flash("msg", "تم حذف اشعار بنجاح");
        return redirect("/admin/notifications");
    }
}
