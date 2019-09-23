<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-19
 * Time: ���� 5:49
 */
class Model
{
    /**
     * �ֻ��� ��Ʈ
     * 
     * @var 
     */
    protected $rootDir;

    /**
     * �������� Object
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
     * �� �ε�
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