<?php

/**
 * 커맨드 Exception
 */
class CommandException extends Exception implements Exceptions
{
    protected $hint;

    public function __construct($message = "", $code = 0, $hint = "")
    {
        parent::__construct($message, $code);

        $this->display();
    }

    public function display()
    {
        print_r(Array(
            'exception',
            $this->getCode(),
            Array(
                'msg'   => iconv('EUC-KR', 'UTF-8', $this->message),
                'code'  => $this->code,
                'trace' => $this->getTrace(),
                'hint'  => $this->hint
            )
        ));
        exit;
    }

    // TODO :: DB에 저장하든 파일로 떨구던 로깅을 해야한다. 크론일수도 있으니까.
    public function save()
    {

    }
}