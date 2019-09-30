# UFramework
- 기본 캐릭터셋은 EUC-KR 입니다. 
- MVC 패턴과 메소드 체이닝 패턴을 이용했습니다.
- jQuery 미사용 request 라이브러리를 포함합니다.
- UDebug 가 추가되었습니다.
- Command 가 추가되었습니다.

## About
<strong>PHP 5.1.4</strong> 이상에서 사용할수 있는 Nano Framework<br>

## Infomation
- Bootstrap.php 의 autoLoad() function 의 변수중, $path 에 해당하는 배열 순서를 변경하지 마세요.

## Install
1. Apache vhost.conf
```apacheconfig
<VirtualHost *:80>
    ServerName uframework.com
    DocumentRoot ~/uframework/public
</VirtualHost>
```

2. Apache httpd.conf
```apacheconfig
<Directory "~/uframework/public">
    AllowOverride All
</Directory>
```

2. Bootstrap.php<br>
데이터베이스 커넥터 정보를 입력합니다.
(LOCAL_CHANEL, DEVELOPE_CHANEL, PRODUCT_CHANEL) Default 는 프로덕트 채널입니다.
```PHP
public function __constracut()
{
    $this->rootDir = Config::getRootDir();
    DBConfig::setDatabaseInfo(LOCAL_CHANEL);
}
```

## UDebug
디버그 클래스 입니다. 기본적으로 session, get/post, router, controller, model 등의
정보를 가지며 추가로 디버깅이 필요한 경우에 store 메소드를 이용하여 추가할수 있습니다. 

```PHP
UDebug::store();
```

Exception 이 발생한 경우 트레이서에서 자동으로 모든 디버깅 변수를 출력해줍니다. 또한 
디버깅 데이터가 필요한 경우 아래 메소드를 호출하여 전달 받습니다.
```PHP
UDebug::pop();
``` 

현재 상황에서 강제로 모든 디버깅 정보 또는 트레이스 정보를 얻고자 할때는
아래 메소드를 이용하여 현재 입력된 모든 디버깅 정보와 트레이스 정보를 얻을수 있습니다.
```PHP
UDebug::display();
```

## Command
서버에서 직접 호출 가능한 command 를 추가했습니다.<br>
크론 작업 및 컨트롤러/모델/라우터 생성 및 제거기능을 포함합니다.<br><br>

1. 컨트롤러 생성
/app/controllers/ 디렉토리에 {controllerName}Controller.php 의 이름으로 생성됩니다. 
```SH
>php command make:controller {controllerName}
```

2. 라우터 생성
/routes/ 디렉토리에 {routerName}Route.php 의 이름으로 생성됩니다.<br>
{controllerName}을 입력하면 해당 라우터를 컨트롤러 이름으로 바인딩 시켜주지만 입력하지 않아도 기본 라우터 이름을 따라갑니다.
```SH
>php command make:router {routerName} {controllerName = routerName}
```

3. 모델 생성
/app/models/ 디렉토리에 {modelName}Model.php 의 이름으로 생성됩니다.
```SH
>php command make:model {modelName}
```

4. 페이지를 한번에 생성
컨트롤러/모델/라우터가 각각 생성됩니다.
```SH
>php command make:all {controllerName}
```