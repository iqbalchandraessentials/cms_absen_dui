<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Announcement;
use App\AnnouncementAttachment;
use App\Helpers\ResponseFormatter;
use App\Models\AnnouncmentRecipient;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AnnouncementController extends Controller
{

    public function index()
    {
        $data = announcement::with(['user'])->get();
        return view('internal_memo.index', ['datas' => $data]);
    }

    public function show($id)
    {
        $data = announcement::with(['attachment', 'user'])->find($id);
        return view('internal_memo.show', ['data' => $data]);
    }

    public function create()
    {
        $department = Department::get();
        return view('internal_memo.create', ['department' => $department]);
    }

    public function update($id, Request $request)
    {
        $announcement =  announcement::find($id);
        $announcement->update($request->all());
        return redirect(route('internal_memo.show', $id));
    }

    public function store(Request $request, User $user)
    {
        try {

            $this->validate($request, [
                'title' => 'required',
                'description' => 'required',
                'publish' => 'required',
            ],[
                'title.required' => 'The "Title" field is required.',
                'description.required' => 'The "Description" field is required.',
                'publish.required' => 'The "Publish" field is required.',
            ]);

            $data = Announcement::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'publish' => $request->publish,
            ]);

            if ($request->publish === "1") {
                $user->sendNotification('GLOBAL_DUI', $request->title, "You have a new announcement 🔔", "memo");
            }

            if (isset($request->receipt_dept)) {
                foreach ($request->receipt_dept as $value) {
                    $receipt = AnnouncmentRecipient::create([
                        'announcment_id' => $data->id,
                        'dept_id' => $value,
                    ]);
                }
            }

            if ($request->upload_file) {
                foreach ($request->upload_file as $value) {
                    $m = new AnnouncementAttachment();
                    $m->announcment_id = $data->id;
                    $file_name = $value->getClientOriginalName() . '.' . $value->extension();
                    $destination = public_path('uploads/announcment');
                    $value->move($destination, $file_name);
                    $m->upload_file = $file_name;
                    $m->save();
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('internal_memo.index');
    }

    public function publish(Request $request, $id, User $user)
    {
        $data = Announcement::find($id);
        $data->publish = 1;
        $data->save();
        $user->sendNotification('GLOBAL_DUI', $data->title, "You have a new announcement 🔔", "memo");
        return redirect()->route('internal_memo.index');
    }

    public function apiList()
    {
        $data = announcement::where('publish', 1)->with(['attachment', 'user'])->latest()->get();
        return ResponseFormatter::success($data, 'okee');
    }

    public function apiShow($id)
    {
        $data = announcement::with(['attachment', 'user'])->find($id);
        return ResponseFormatter::success($data, 'okee');
    }
}
