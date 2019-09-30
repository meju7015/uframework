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
              '필수 파라미터가 누락되었습니다. 생성할 모델 이름을 입력해 주세요.'),
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
            echo "모델이 생성되었습니다.";
        }
    }else {
        throw new CommandException(
            '이미 해당 모델이 존재합니다.',
            601
        );
    }

    public function makeController($params)
    {
        if (empty($params[2])) {
            throw new CommandException(
              '필수 파라미터가 누락되었습니다. 생성할 컨트롤러 이름을 입력해 주세요.',
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
                echo "컨트롤러가 생성되었습니다.";
            }
        } else {
            throw new CommandException(
                '이미 해당 컨트롤러가 존재합니다.',
                601
            );
        }
    }

    public function makeRouter($params)
    {

    }
}