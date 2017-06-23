<?php

namespace App\Traits;
use App\Models\Document;
use Illuminate\Support\Facades\DB;


/**
 * Class AssociateCreateTrait
 * @package App\Traits
 */
trait AssociateSaveTrait {

    /**
     * 便捷的快速添加关联数据
     * @param array $documentData
     * @param array $modelData
     *
     * @return bool
     */
    public static function associateCreate($documentData = [], $modelData = [])
    {
        $instance = new static;
        // 兼容传入数组或Model
        if ($documentData instanceof Document) {
            $document = $documentData;
        } else {
            $document = Document::create($documentData);
        }
        if ($document) {
            // 兼容传入数组或Model
            if ($modelData instanceof self) {
                return $instance->create(array_merge($modelData->toArray(), ['id' => $document->id]));
            } else {
                return $instance->create(array_merge($modelData, ['id' => $document->id]));
            }
        } else {
            return false;
        }
    }

    /**
     * 便捷的快速更新关联数据
     *
     * @param array $documentData
     * @param array $modelData
     *
     * @return $this|bool
     */
    public function associateUpdate($documentData = [], $modelData = [])
    {
        // 兼容传入数组或Model
        $modelId = $this->id;
        DB::beginTransaction();
        if(!Document::where(function($query) use ($modelId) {
            $query->where($this->primaryKey, $modelId);
        })->update($documentData)) {
            DB::rollBack();
            return false;
        }
        // 兼容传入数组或Model
        if (!($modelData instanceof self)) {
            foreach ($modelData as $k => $v) {
                $this->$k = $v;
            }
        }
        if ($this->save()) {
            DB::commit();
            return $this;
        } else {
            DB::rollBack();
            return false;
        }
    }
    public static function relatedCreate($documentData = [], $modelData = [])
    {
        $instance = new static;
        // 兼容传入数组或Model
        if ($documentData instanceof Document) {
            $document = $documentData;
        } else {
            $document = $instance::create($documentData);
        }
        if ($document) {
            $instance->document()->associate($document);
            // 兼容传入数组或Model
            if ($modelData instanceof self) {
                return $instance->create(array_merge($modelData->toArray(), ['id' => $document->id]));
            } else {
                return $instance->create(array_merge($modelData, ['id' => $document->id]));
            }
        } else {
            return false;
        }
    }

}
