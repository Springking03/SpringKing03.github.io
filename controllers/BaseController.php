<?php
class BaseController{
    const VIEW_FOLDER_NAME = 'views';
    const MODEL_FOLDER_NAME = 'models';
    /**
     * @param $path : folderName.fileName
     * configs gọi path view cho ngắn gọn hơn
     */
    protected function view($viewPath, array $data = []){
        extract($data);
        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.','/',$viewPath) . '.php';
        return require($viewPath);
    }

    protected function loadModel($modelPath){
        $modelPath = self::MODEL_FOLDER_NAME . '/' . $modelPath . '.php';
        return require($modelPath);
    }
}