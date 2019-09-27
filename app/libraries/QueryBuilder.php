<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: ���� 2:19
 */
class QueryBuilder
{
    protected $table;
    protected $where;
    protected $order;
    protected $limit;
    protected $columns;
    protected $join;
    protected $and;
    protected $or;

    protected $pdo;

    public function __construct(stdClass $pdo)
    {
        $this->pdo = $pdo;
    }

    private function whereFormat($item)
    {
        $where = "{$item[0]} {$item[1]} ";

        if (is_integer($item[2])) {
            $where .= $item[2];
        } elseif (in_array($item[2], $this->columns)) {
            $where .= $item[2];
        } elseif (is_string($item[2])) {
            $where .= "'{$item[2]}'";
        } elseif (is_null($item[2])) {
            $where .= "null";
        } elseif (empty($item[2])) {
            $where .= "''";
        } else {
            throw new PDOException('���� ������ �߸��Ǿ����ϴ�.');
        }

        return $where;
    }

    public function find()
    {
        echo '<pre style="background-color:black; color:greenyellow;margin:0;padding:10px;">';
        print_r($this);
        echo '</pre>';
        // TODO :: find ������ select �� �̿��ϱ⶧���� slave������ �����°��� �⺻������.
        // ��� �ϴ� �޼ҵ� where, column, order, lomit, join, and

        try {
            if (empty($this->table) || $this->table === ' ') {
                throw new PDOException('���̺��� �Էµ��� �ʾҽ��ϴ�.');
            }

            $where = "";

            if (!empty($this->where) && !empty($this->or)) {
                $where .= "WHERE (" . implode(' AND ', $this->where) . ")";
            }

            if (!empty($this->and) && !empty($this->or)) {
                $where .= "(" . implode(' AND ', $this->and) . ")";
            }

            echo $where;


        } catch (PDOException $e) {
            $viewException = new ModelException($e->getMessage(), 500);
            $viewException->display();
        }


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
     * ��� ���̺�
     * 
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * ��� �÷�
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

    /**
     * Where Conditions
     *
     * @param $conditions
     * @return $this
     */
    public function where($conditions)
    {
        if (sizeof($conditions[1]) > 1) {
            foreach ($conditions as $key => $item) {
                if (is_array($item)) {
                    if (empty($item) || $item === ' ') {
                        continue;
                    }

                    $this->where[] = $this->whereFormat($item);
                }
            }
        } else {
            if (is_array($conditions)) {
                if (empty($conditions) || $conditions === ' ') {
                    return $this;
                }

                $this->where[] = $this->whereFormat($conditions);
            }
        }

        return $this;
    }

    /**
     * Where and conditions
     *
     * @param $conditions
     * @return $this
     */
    public function whereAnd($conditions)
    {
        if (sizeof($conditions[1]) > 1) {
            foreach ($conditions as $key => $item) {
                if (is_array($item)) {
                    if (empty($item) || $item === ' ') {
                        continue;
                    }

                    $this->and[] = $this->whereFormat($item);
                }
            }
        } else {
            if (is_array($conditions)) {
                if (empty($conditions) || $conditions === ' ') {
                    return $this;
                }

                $this->and[] = $this->whereFormat($conditions);
            }
        }

        return $this;
    }

    public function whereOr($conditions)
    {
        if (sizeof($conditions[1]) > 1) {
            foreach ($conditions as $key => $item) {
                if (is_array($item)) {
                    if (empty($item) || $item === ' ') {
                        continue;
                    }

                    $this->or[] = $this->whereFormat($item);
                }
            }
        } else {
            if (is_array($conditions)) {
                if (empty($conditions) || $conditions === ' ') {
                    return $this;
                }

                $this->or[] = $this->whereFormat($conditions);
            }
        }

        return $this;
    }
}