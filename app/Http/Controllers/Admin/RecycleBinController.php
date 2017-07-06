<?php

namespace App\Http\Controllers\Admin;


use App\Models\RecycleBin\RecycleBin;

class RecycleBinController extends BaseController
{
    public function __construct(RecycleBin $model)
    {
        $this->model = $model;
        parent::__construct();

        $this->sort = 'id desc';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = $this->model->addNestedWhereQuery($this->where)->orderByRaw($this->sort)->paginate();
        return view('admin.recycle_bin.index', compact('lists'));
    }

    public function destroy($id=0)
    {
        if ($this->model::destroy(str2arr($id))) {
            return $this->flash('删除成功', 'success');
        } else {
            return $this->flash('删除失败', 'danger');
        }
    }

    public function restore($id=0)
    {
        \DB::transaction(function () use ($id) {
            $lists = $this->model->whereIn('id', str2arr($id))->get()->groupBy('table_name');
            foreach ($lists as $key => $item) {
                if(\DB::table($key)->whereIn('id', $item->pluck('object_id')->toArray())->update(['deleted_at' => null])) {
                    $this->model::destroy($item->pluck('id')->toArray());
                }
            }
        }, 2);
        return $this->flash("还原成功", 'success');
    }
}
