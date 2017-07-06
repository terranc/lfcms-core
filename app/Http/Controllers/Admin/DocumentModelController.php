<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DocumentModelRequest;
use App\Models\DocumentModel\DocumentModel;

class DocumentModelController extends BaseController
{
    public function __construct(DocumentModel $model)
    {
        $this->model = $model;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lists = $this->model::paginate();
        return view('admin.document_model.index', compact('lists'));
    }

    public function create()
    {
        return view('admin.document_model.form');
    }

    public function store(DocumentModelRequest $request)
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
        return view('admin.document_model.form', compact('data'));
    }

    public function update($id, DocumentModelRequest $request)
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
