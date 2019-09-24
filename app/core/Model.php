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
     * PDO °´Ã¼
     * 
     * @var PDO 
     */
    protected $connect;

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

        $dbInfo = DBConfig::getDatabaseInfo();

        try {
            $this->connect = new PDO(
                $dbInfo->dsn,
                $dbInfo->userName,
                $dbInfo->password
            );
        } catch (PDOException $e) {
            $viewException = new ModelException($e->getMessage(), 500);
            $viewException->display();
        }
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