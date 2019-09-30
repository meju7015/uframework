<?php
class MakeController extends Controller
{
    public function __construct()
    {

    }

    public function makeAll($params)
    {
        if ($this->makeController($params)) {
            $this->makeRouter($params);
            $this->makeModel($params);

            echo "complete..!".PHP_EOL;
        };
    }

    public function makeModel($params)
    {
        if (empty($params[2])) {
            throw new CommandException(
              '�ʼ� �Ķ���Ͱ� �����Ǿ����ϴ�. ������ �� �̸��� �Է��� �ּ���.',
              600
            );
        }

        $modelName = $params[2];
        $modelPath = Config::getRootDir()."app/models/".$modelName."Model.php";

        $contents = file_get_contents(Config::getRootDir()."app/samples/model.sample");

        $contents = str_replace('{{model}}', ucfirst($modelName)."Model", $contents);
        $contents = str_replace('{{extends}}', 'Model', $contents);

        if (!file_exists($modelPath)) {
            if (file_put_contents($modelPath, $contents)) {
               return true;
            }
        }else {
            throw new CommandException(
                '�̹� �ش� ���� �����մϴ�.',
                601
            );
        }

        return false;
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
        $controllerPath = Config::getRootDir()."app/controllers/".$controllerName."Controller.php";

        $contents = file_get_contents(Config::getRootDir()."app/samples/controller.sample");

        $contents = str_replace('{{controller}}', ucfirst($controllerName)."Controller", $contents);
        $contents = str_replace('{{extends}}', 'Controller', $contents);
        $contents = str_replace('{{implements}}', 'Controllable', $contents);

        if (!file_exists($controllerPath)) {
            if (file_put_contents($controllerPath, $contents)) {
                return true;
            }
        } else {
            throw new CommandException(
                '�̹� �ش� ��Ʈ�ѷ��� �����մϴ�.',
                601
            );
        }

        return false;
    }

    public function makeRouter($params)
    {
        if (empty($params[2])) {
            throw new CommandException(
              '�ʼ� �Ķ���Ͱ� �����Ǿ����ϴ�. ������ ����� �� ����� ��Ʈ�ѷ��� �̸��� �Է��� �ּ���.',
              600
            );
        }

        $routerName = $params[2];
        $routerPath = Config::getRootDir()."routes/".ucfirst($routerName)."Route.php";

        $contents = file_get_contents(Config::getRootDir()."app/samples/router.sample");

        $contents = str_replace('{{router}}', ucfirst($routerName)."Router", $contents);
        $contents = str_replace('{{routeName}}', strtolower($routerName), $contents);

        if (!empty($params[3])) {
            $contents = str_replace('{{controller}}', $params[3], $contents);
        } else {
            $contents = str_replace('{{controller}}', $routerName."Controller", $contents);
        }

        if (!file_exists($routerPath)) {
            if (file_put_contents($routerPath, $contents)) {
                return true;
            }
        } else {
            throw new CommandException(
                '�̹� �ش� ����Ͱ� �����մϴ�.',
                601
            );
        }

        return false;
    }
}