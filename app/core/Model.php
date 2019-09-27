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
     * PDO ��ü
     * 
     * @var PDO 
     */
    protected $connect;

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
        $this->rootDir = Config::getRootDir();

        $dbInfo = DBConfig::getDatabaseInfo();

        try {
            if (is_array($dbInfo)) {
                foreach ($dbInfo as $key => $item) {
                    $this->connect[$key] = new PDO(
                        $item['dsn'],
                        $item['userName'],
                        $item['password']
                    );
                }
            } else {
                throw new PDOException('error', 500);
            }

            $this->builder = new QueryBuilder((object)$this->connect);

        } catch (PDOException $e) {
            // TODO :: slave key �� connection �� �ȵǾ������� select query �� master�� ������ �α׸� �״´�.

            $viewException = new ModelException($e->getMessage(), 500);
            $viewException->display();
        }
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
        $modelFile = "{$this->rootDir}app/models/{$model}.php";

        if (file_exists($modelFile)) {
            include_once $modelFile;
            return new $model();
        } else {
            throw new ModelException('�� ������ ã�� �� �����ϴ�.', 405);
        }
    }
}