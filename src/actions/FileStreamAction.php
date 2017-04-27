<?php

namespace tecnocen\roa\actions;

use Yii;

use tecnocen\roa\FileResource;

/**
 * Access and show s the content of a file on the browser or download it.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class FileStream extends Action
{
    /**
     * @var string GET parameter to decide if force the download or show it on
     * the browser.
     */
    public $downloadParam = 'download';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $interfaces = class_implements($this->modelClass);
        if (empty($interfaces[FileResource::class])) {
            throw new InvalidConfigException(
                "The class `{$this->modelClass}` must implement "
                    . FileResource::class
            );
        }
    }

    /**
     * Shows the file on the browser or download it after checking access.
     *
     * @param mixed $id the identifier value.
     * @param string $ext the requested file extension.
     */
    public function run($id, $ext)
    {
        $this->checkAccess(
            ($model = $this->findModel($id)),
            Yii::$app->request->queryParams
        );

        return Yii::$app->response->sendFile(
            $model->filePath($ext),
            $model->fileName($ext),
            [
                'mimeType' => $model->fileMimeType($ext),
                'inline' => !Yii::$app->request
                    ->getQueryParam($this->downloadParam, false),
            ]
        );
    }
}
