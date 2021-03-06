<?php

namespace app\api\models;

use tecnocen\roa\behaviors\Curies;
use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;
/**
 * ROA contract to handle SoftDelete records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class SoftDelete extends \app\models\SoftDelete implements Linkable, Embeddable
{
    use EmbeddableTrait {
        EmbeddableTrait::toArray as embedArray;
    }
    
    /**
     * @inheritdoc
     */
    public function toArray(
        array $fields = [],
        array $expand = [],
        $recursive = true
    ) {
        return $this->embedArray(
            $fields ?: $this->attributes(),
            $expand,
            $recursive
        );
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'soft-delete',
            ],
            'curies' => Curies::class,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), $this->getCuriesLinks(), [
            'soft-delete' => $this->getSelfLink() . '/soft-delete',
        ]);
    }

}