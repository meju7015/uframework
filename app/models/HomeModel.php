<?php
/**
 * Class HomeModel
 */
class HomeModel extends Model
{
    public function selectUsers($userID)
    {
        $this->builder
            ->table('Users')
            ->column(
                Array(
                    'User',
                    'Password'
                )
            )
            ->where(
                Array(
                    Array('User', '=', 'root'),
                    Array('Password', '=', ''),
                )
            )
            ->whereOr(
                Array('Email', '=', '*')
            )
            ->find();
    }
}