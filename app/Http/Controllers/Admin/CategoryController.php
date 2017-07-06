<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category\Category;

class CategoryController extends BaseController
{
    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct();

        $this->sort = 'sort_id asc, id asc';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lists = $this->model->orderByRaw($this->sort)->paginate();
        return view('admin.category.index', compact('lists'));
    }

    public function create()
    {
        return view('admin.category.form');
    }

    public function store(CategoryRequest $request)
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
        return view('admin.category.form', compact('data'));
    }

    public function update($id, CategoryRequest $request)
    {
        $data = $request->all();
        foreach ($this->request->files as $key => $item) {
            $thumb = upload_image($item, 'category');
            if ($thumb['error']) {
                return $this->apiResponse(-2, $thumb['error']);
            }
            $data[$key] = $thumb['url'];
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
}
