<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public $model;

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 0, $columns = ['*'])
    {
        return $this->model->paginate($perPage ?: 15, $columns);
    }

    /**
     * Create a new document
     * @param array $data
     * @return \App\Models\Document
     */
    public function create($data = [])
    {
        return $this->model->create($data);
    }

    /**
     * Update a document
     * @param array $data
     * @param $id
     * @return \App\Models\Document
     */
    public function update($id, $data = [])
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->whereId($id)->first($columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }
    /**
     * @return mixed
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function get($id, $columns = ['*'])
    {
        return $this->model->whereId($id)->get($columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function getBy($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, '=', $value)->get($columns);
    }

    /**
     * Delete a document
     * @param $id
     * @return \App\Models\Document
     */
    public function delete($id)
    {
        $deleted = $this->model->destroy(explode(',', $id));
        return $deleted;
    }

    /**
     * @param Model $model
     *
     * @return bool|null
     */
    public function forceDelete(Model $model)
    {
        $deleted = $model->forceDelete();
        return $deleted;
    }
    /**
     * @param Model $model
     *
     * @return bool|null
     */
    public function restore(Model $model)
    {
        $restore = $model->restore();
        return $restore;
    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
//    function __call($method, $args)
//    {
//        $callable = [$this->query, $method];
//
//        return call_user_func_array($callable, $args);
//    }
}
