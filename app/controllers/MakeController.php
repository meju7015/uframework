<?php
class MakeController extends Controller
{
    public function __construct()
    {
    }

    public function makeModel($params)
    {
        if (empty($params[2]) {
            throw new CommandException(
              '�ʼ� �Ķ���Ͱ� �����Ǿ����ϴ�. ������ �� �̸��� �Է��� �ּ���.'),
              600
        };
    }

    $modelName = $params[2];
    $modelPath = Config::getRootDir()."app/models/".$modelName.".php";

    $contents = file_get_contents(Config::getRootDir()."app/samples/model.sample");

    $contents = str_replace('{{model}}', $modelName, $contents);
    $contents = str_replace('{{extends}}', 'Model', $contents);

    if (!file_exists($modelPath)) {
        if (file_put_contents($modelPath, $contents) {
            echo "���� �����Ǿ����ϴ�.";
        }
    }else {
        throw new CommandException(
            '�̹� �ش� ���� �����մϴ�.',
            601
        );
    }

    public function makeController($params)
    {
        if (empty($params[2])) {
            throw new CommandException(
              '�ʼ� �Ķ���Ͱ� �����Ǿ����ϴ�. ������ ��Ʈ�ѷ� �̸��� �Է��� �ּ���.',
              600
            );
        }

        $controllerName = $params[2];
        $controllerPath = Config::getRootDir()."app/controllers/".$controllerName.".php";

        $contents = file_get_contents(Config::getRootDir()."app/samples/controller.sample");

        $contents = str_replace('{{controller}}', $controllerName, $contents);
        $contents = str_replace('{{extends}}', 'Controller', $contents);
        $contents = str_replace('{{implements}}', 'Controllable', $contents);

        if (!file_exists($controllerPath)) {
            if (file_put_contents($controllerPath, $contents)) {
                echo "��Ʈ�ѷ��� �����Ǿ����ϴ�.";
            }
        } else {
            throw new CommandException(
                '�̹� �ش� ��Ʈ�ѷ��� �����մϴ�.',
                601
            );
        }
    }

    public function makeRouter($params)
    {

    }
}