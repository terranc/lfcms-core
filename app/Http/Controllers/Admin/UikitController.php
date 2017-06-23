<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;

class UikitController extends Controller
{
    function index() {
        $users = User::orderBy('id','desc')->paginate();
        return view('admin.uikit.index', compact('users'));
    }

    public function create()
    {
        return view('admin.uikit.form');
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['id'] = User::create($data);
        if ($data['id']) {
            return $this->redirectUrl($request->input('from_url'))->apiResponse(1, '添加成功！', $data['id']);
        } else {
            return $this->redirectUrl($request->input('from_url'))->apiResponse(-1, '添加失败');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.uikit.form', compact('user'));
    }

    public function update($id, UserRequest $request)
    {
        $data = $request->all();
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $ret = User::find($id)->update($data);
        if ($ret) {
            return $this->apiResponse(1, '保存成功！', $data);
        } else {
            return $this->apiResponse(-1, '保存失败');
        }
    }

    public function destroy($id=0)
    {
        if (User::destroy(str2arr($id))) {
            return $this->flash('删除成功', 'success');
        } else {
            return $this->flash('删除失败', 'danger');
        }
    }

    public function enable(User $user, Request $request)
    {
        $ids = $request->input('id');
        $user->whereIn('id', $ids)->update(['status'=>1]);
        return $this->flash('操作成功！', 'success');
    }

    public function disable(User $user, Request $request)
    {
        $ids = $request->input('id');
        $user->whereIn('id', $ids)->update(['status'=>0]);
        return $this->flash('操作成功！', 'success');
    }
}
