<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ConfigRequest;
use App\Models\Config\Config;
use App\Repositories\ConfigRepository;

class ConfigController extends BaseController
{
    public function __construct(Config $model)
    {
        $this->model = $model;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ConfigRepository $configRepository)
    {
        $lists = $this->model->addNestedWhereQuery($this->where)->paginate();
        $namespace_lists = $configRepository->getNamespaceLists();
        return view('admin.config.index', compact('lists', 'namespace_lists'));
    }

    public function create()
    {
        return view('admin.config.form');
    }

    public function store(ConfigRequest $request)
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
        return view('admin.config.form', compact('data'));
    }

    public function update($id, ConfigRequest $request)
    {
        $data = $request->all();
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
}
