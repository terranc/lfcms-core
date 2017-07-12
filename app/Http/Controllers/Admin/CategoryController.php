<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Libraries\Tree;
use App\Models\Category\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends BaseController
{
    public function __construct(Category $model, CategoryRepository $categoryRepository)
    {
        $this->model = $model;
        $this->repository = $categoryRepository;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = array2object($this->repository->tree());

//        foreach ($lists as $key => &$val) {
//            $val->spacer = str_repeat('—', $val->_level - 1);
//        }
        return view('admin.category.index', compact('lists'));
    }

    public function create()
    {
        return view('admin.category.form');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        foreach ($this->request->files as $key => $item) {
            $thumb = upload_image($item, 'category');
            if ($thumb['error']) {
                return $this->apiResponse(-2, $thumb['error']);
            }
            $data[$key] = $thumb['url'];
        }
        $data['id'] = $this->repository->create($data);
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

    public function update($id, CategoryRequest $request, CategoryRepository $categoryRepository)
    {
        $data = $request->all();
        foreach ($this->request->files as $key => $item) {
            $thumb = upload_image($item, 'category');
            if ($thumb['error']) {
                return $this->apiResponse(-2, $thumb['error']);
            }
            $data[$key] = $thumb['url'];
        }
        $ret = $categoryRepository->update($id, $data);
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
