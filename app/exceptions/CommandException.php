<?php

/**
 * Ŀ�ǵ� Exception
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

    // TODO :: DB�� �����ϵ� ���Ϸ� ������ �α��� �ؾ��Ѵ�. ũ���ϼ��� �����ϱ�.
    public function save()
    {

    }
}