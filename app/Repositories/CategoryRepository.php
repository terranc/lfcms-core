<?php

namespace App\Repositories;

use App\Events\CategoryDelete;
use App\Libraries\Tree;
use App\Models\Category\Category;
use App\Exceptions\GeneralException;
use App\Scopes\HideContentScope;
use App\Traits\JsonResponseTrait;

class CategoryRepository extends BaseRepository
{
    use JsonResponseTrait;

    public $model, $query;

    public function __construct(Category $category)
    {
        $this->model = $category;
        $this->query = $this->model->query();
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->withoutGlobalScope(HideContentScope::class)->find($id);
    }

    public function getChildrenIds($root = 0)
    {
        $data = $this->model->orderByRaw('sort_id asc, id asc')->get()->toArray();
        $tree = new Tree();
        $tree->init($data);
        return $tree->getChildrenIds($root);
    }


    public function tree($root = 0)
    {
        $data = $this->model->orderByRaw('sort_id asc, id asc')->get()->toArray();
        $tree = new Tree();
        $tree->init($data);
        return $tree->getTreeArray($root);
//        if ($type === 'normal') {
//            return Tree::makeTree($data);
//        } else if ($type === 'linear') {
//            return Tree::makeTreeForHtml($data);
//        }
    }

    public function makeTreeOption($root = 0, $selected = 0)
    {
        $data = $this->model->orderByRaw('sort_id asc, id asc')->get()->toArray();
        $tree = new Tree();
        $tree->icon = ['│', '├─', '└─'];
        $tree->nbsp = '　';
        $tree->init($data);
        $str = '<option value=\"{$id}\" {$selected}>{$spacer}{$title}</option>';
        $treeStr = $tree->getTree($root, $str, $selected);
        return $treeStr;
    }

    public function delete($id)
    {
        return \DB::transaction(function () use ($id) {
            foreach ($id as $key => $val) {
                $category = $this->model->whereId($val)->first();
                if ($category->is_system) {
                    return $this->apiArray(-2, "『{$category->title}』是系统分类，无法删除");
                }
                if ($this->getChildrenIds($val)) {
                    return $this->apiArray(-3, "请先删除『{$category->title}』的子级分类");
                }
                event(new CategoryDelete($category));
                $this->model::destroy($val);
            }
            return $this->apiArray(1, "删除成功");
        });
    }
}
