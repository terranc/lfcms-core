<?php

namespace App\Traits;
use App\Models\Document;
use App\Models\DocumentModel;
use Znck\Eloquent\Traits\BelongsToThrough;


/**
 * Class RelationModelTrait
 * @package App\Traits
 */
trait AssociateModelTrait {

    use BelongsToThrough;

    /**
     * 让 Document 扩展 Model 可通过 ->model 获取对应 DocumentModel
     * @return \Znck\Eloquent\Relations\BelongsToThrough
     */
    public function model()
    {
        return $this->belongsToThrough(DocumentModel::class, [[Document::class, $this->primaryKey]], null, '', [DocumentModel::class => 'model_id']);
    }
}
