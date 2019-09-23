<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-19
 * Time: ¿ÀÈÄ 5:49
 */
class Model
{
    /**
     * ÃÖ»óÀ§ ·çÆ®
     * 
     * @var 
     */
    protected $rootDir;

    /**
     * Äõ¸®ºô´õ Object
     * 
     * @var QueryBuilder 
     */
    public $builder;

    public function __construct()
    {
        $this->builder = new QueryBuilder();
        $this->rootDir = Config::getRootDir();
    }

    /**
     * ¸ðµ¨ ·Îµå
     * 
     * @param string    $model
     * @return Object|false
     * @throws ModelException
     */
    public function loadModel($model)
    {
        $modelFile = "{$this->rootDir}/models/{$model}.php";

        if (file_exists($modelFile)) {
            return new $model();
        } else {
            throw new ModelException('not found model file', 405);
        }
    }
}