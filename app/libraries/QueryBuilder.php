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