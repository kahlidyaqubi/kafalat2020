<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\RelationshipRequest;
use App\Relationship;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class RelationshipController
 * @package App\Http\Controllers\Admin
 */
class RelationshipController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $relationships = Relationship::all();
        return view('admin.relationship.list', compact('relationships'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.relationship.create');
    }

    /**
     * @param RelationshipRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RelationshipRequest $request)
    {
        $message = null;

        $item = Relationship::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;

        if ($relationship = Relationship::create($request->all())) {
            $message = 'تم إضافة صلة القرابة بنجاح';

            event(new NewLogCreated($message, $request['name'], 52, 1, url('admin/relationships/' . $relationship->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة صلة القرابة بنجاح';

            event(new NewLogCreated($message, $request['name'], 52, 0, null));
            return back()->with('error', $message);
        }   } else {

            $message = 'لم يتم إضافة صلة القرابة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 52, 0, null));
            return back()->with('error', $message);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_null($id)) {
            $relationship = Relationship::find($id);

            if (!is_null($relationship)) {

                return view('admin.relationship.edit', compact('relationship'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
                return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
            return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

    /**
     * @param RelationshipRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(RelationshipRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $relationship = Relationship::find($id);

            if (!is_null($relationship)) {

                $request['updated_by'] = Auth::user()->id;
                if ($relationship->update($request->all())) {
                    $message = 'تم تحديث صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 53, 1, url('admin/relationships/' . $relationship->id . '/edit')));
                    return redirect('admin/relationships')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 53, 0, null));
                    return redirect('admin/relationships')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
                return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
            return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $relationship = Relationship::find($id);

            if (!is_null($relationship)) {
                $name = $relationship->name;

                if ((($relationship->member)->isEmpty()) && (($relationship->family)->isEmpty()) && (($relationship->representative_relationships)->isEmpty())) {
                    if ($relationship->delete()) {
                        event(new NewLogCreated('تم حذف صلة القرابة بنجاح ', $name, 54, 0, null));
                        return redirect('admin/relationships')->with('success', 'تم حذف صلة القرابة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف صلة القرابة بنجاح  ', $name, 54, 0, null));
                    return redirect('admin/relationships')->with('error', 'لم يتم حذف صلة القرابة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف صلة القرابة بنجاح لوجود عناصر مرتبطة بها ', $name, 54, 0, null));
                    return redirect('admin/relationships')->with('error', 'لم يتم حذف صلة القرابة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 54, 0, null));
                return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 54, 0, null));
            return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {

        if (!is_null($id)) {
            $relationship = Relationship::find($id);

            if (!is_null($relationship)) {
                if ($relationship->update(['status' => 1])) {
                    $message = 'تم قبول صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $relationship->name, 55, 1, url('admin/relationships/' . $relationship->id . '/edit')));
                    return redirect('admin/relationships')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $relationship->name, 55, 1, url('admin/relationships/' . $relationship->id . '/edit')));
                    return redirect('admin/relationships')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على صلة القرابة بنجاح برقم : ', $id, 55, 0, null));
                return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 55, 0, null));
            return redirect('admin/relationships')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

}
