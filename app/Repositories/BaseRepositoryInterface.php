<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/7/14
 * Time: 13:58
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{

    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param int   $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($perPage = 0, $columns = ['*']);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create($data = []);

    /**
     * @param       $id
     * @param array $data
     *
     * @return mixed
     */
    public function update($id, $data = []);

    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @return mixed
     */
    public function count();

    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function get($id, $columns = ['*']);

    /**
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function getBy($field, $value, $columns = ['*']);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param \App\Repositories\Model $model
     *
     * @return mixed
     */
    public function forceDelete(Model $model);

    /**
     * @param \App\Repositories\Model $model
     *
     * @return mixed
     */
    public function restore(Model $model);

}
