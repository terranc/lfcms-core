<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User\User;

class UikitController extends BaseController
{

    /**
     * UikitController constructor.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    function index() {
        $lists = $this->model::orderBy('id','desc')->paginate();
        return view('admin.uikit.index', compact('lists'));
    }

    public function create()
    {
        return view('admin.uikit.form');
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['id'] = $this->model::create($data);
        if ($data['id']) {
            return $this->redirectUrl($request->input('from_url'))->apiResponse(1, '添加成功！', $data['id']);
        } else {
            return $this->redirectUrl($request->input('from_url'))->apiResponse(-1, '添加失败');
        }
    }

    public function edit($id)
    {
        $data = $this->model::find($id);
        return view('admin.uikit.form', compact('data'));
    }

    public function update($id, UserRequest $request)
    {
        $data = $request->all();
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $ret = $this->model::find($id)->update($data);
        if ($ret) {
            return $this->apiResponse(1, '保存成功！', $data);
        } else {
            return $this->apiResponse(-1, '保存失败');
        }
    }

    public function destroy($id=0)
    {
        if ($this->model::destroy(str2arr($id))) {
            return $this->flash('删除成功', 'success');
        } else {
            return $this->flash('删除失败', 'danger');
        }
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable()
    {
        $ids = $this->request->input('id');
        $this->model->whereIn('id', $ids)->update(['status'=>1]);
        return $this->flash('操作成功！', 'success');
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable()
    {
        $ids = $this->request->input('id');
        $this->model->whereIn('id', $ids)->update(['status'=>0]);
        return $this->flash('操作成功！', 'success');
    }
}
