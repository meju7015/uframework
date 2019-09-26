<?php
/**
 * Class HomeModel
 */
class HomeModel extends Model
{
    public function selectUsers($userID)
    {
        $this->builder
            ->column('*')
            ->where(
                Array('User', '=', 'root'),
                Array('Password', '=', '')
            )
            ->find();
    }
}