# uframework
PHP 5.4 이하에서 사용할수 있는 Nano Framework

- 기본 캐릭터셋은 EUC-KR 입니다. 
- MVC 패턴과 메소드 체이닝 패턴을 이용했습니다.
- jQuery 미사용 request 라이브러리를 포함합니다.
- UDebug 추가되었습니다.

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