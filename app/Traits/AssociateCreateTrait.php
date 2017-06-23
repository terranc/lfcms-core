<?php

namespace App\Traits;
use App\Models\Document;


/**
 * Class AssociateCreateTrait
 * @package App\Traits
 */
trait AssociateCreateTrait {

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
