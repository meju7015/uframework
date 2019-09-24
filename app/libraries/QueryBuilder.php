<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: 오후 2:19
 */
class QueryBuilder
{
    protected $where;
    protected $order;
    protected $limit;
    protected $columns;
    protected $join;
    protected $and;
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find()
    {
        // TODO :: find 에서는 select 를 이용하기때문에 slave쪽으로 보내는것을 기본값으로.
        // 사용 하는 메소드 where, column, order, lomit, join, and
    }

    public function findAll()
    {
        // column, order, limit, join
    }

    public function findCount()
    {
        // where, column, order, limit, join, and
    }

    public function insert()
    {
        // column, values
    }

    public function insertAfterId()
    {
        // column, values
    }

    public function update()
    {
        // column, values, where
    }

    public function updateAll()
    {
        // column, values
    }

    /**
     * 사용 컬럼
     * 
     * @param string|array  $columns
     * @return Object       $this
     */
    public function column($columns)
    {
        if (is_array($columns)) {
            foreach ($columns as $key => $item) {
                $this->columns[] = $item;
            }
        } elseif (is_string($columns)) {
            $this->columns[] = $columns;
        }

        return $this;
    }

    public function where($conditions)
    {
        foreach ($conditions as $key => $item) {
            if (is_array($item)) {
                if (empty($item) || $item === ' ') {
                    continue;
                }

                $this->where[] = implode(' ', $item);

            }
        }

        return $this;
    }

    public function whereAnd($conditions)
    {
        if (is_array($conditions)) {
            foreach ($conditions as $key => $item) {
                if (empty($item) || $item === ' ') {
                    continue;
                }

                $this->and[] = implode(' ', $item);
            }
        }

        return $this;
    }
}