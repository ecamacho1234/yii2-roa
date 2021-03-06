<?php

namespace app\api\resources;

use Yii;
use yii\web\NotFoundHttpException;
use app\api\models\File;
use app\api\models\FileSearch;

/**
 * CRUD Resource for `File` records.
 */
class FileResource extends \tecnocen\roa\controllers\Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = File::class;

    /**
     * @inheritdoc
     */
    public $searchClass = FileSearch::class;

    /**
     * @inheritdoc
     */
    public $createFileAttributes = ['path'];

    /**
     * @inheritdoc
     */
    public $updateFileAttributes = ['path'];
}
