<?php

namespace App\Model\Base;

use Phalcon\Mvc\Model;
use Exception;

class Core extends Model
{

    private $model = 'App\Model\\';

    public function isValid($modelName, $arrWhere = [], $isTotal = false)
    {
        try {
            $model = $this->model . $modelName;
            $condition = '';
            $bind = [];
            foreach ($arrWhere as $k => $where) {
                switch (count($where)) {
                    case 2:
                        $condition .= "$where[0] $where[1] AND ";
                        break;
                    case 3:
                        $condition .= "$where[0] $where[1] ?$k AND ";
                        $bind[$k] = $where[2];
                        break;
                    default:
                        $condition .= "$where[0] AND ";
                        break;
                }
            }
            $total = $model::count([substr($condition, 0, -5), 'bind' => $bind]);
            return $isTotal === true ? $total : ($total > 0 ? true : false);
        } catch (Exception $e) {

        }
        return false;
    }

    public function queryAll($arrQuery)
    {
        try {
            $select = empty($arrQuery['select']) ? '*' : $arrQuery['select'];
            $from = empty($arrQuery['from']) ? $this->model : $this->model . $arrQuery['from'];
            $join = empty($arrQuery['join']) ? '' : $arrQuery['join'];
            $where = empty($arrQuery['where']) ? '1' : $arrQuery['where'];
            $group_by = empty($arrQuery['group_by']) ? '' : 'GROUP BY ' . $arrQuery['group_by'];
            $order_by = empty($arrQuery['order_by']) ? '' : 'ORDER BY ' . $arrQuery['order_by'];
            $limit = empty($arrQuery['limit']) ? '' : 'LIMIT ' . $arrQuery['limit'];
            $phql = "SELECT $select FROM $from $join WHERE $where $group_by $order_by $limit";

            $res = $this->modelsManager->createQuery($phql)->execute();
            return $res->count() > 0 ? $res->toArray() : [];
        } catch (Exception $e) {
            //Log::write('ERROR', $e->getMessage(), __CLASS__ . ':' . __FUNCTION__ . ':' . $e->getLine());
        }
        return false;
    }

    public function getUsers()
    {
        try {
            $arrQuery = [
                'select' => 'id,emp_id',
                'from' => 'User'
            ];
            return $data = $this->queryAll($arrQuery);
//            $phql = "SELECT count(*) FROM App\Model\User WHERE 1
//                LIMIT 10 OFFSET 0";
//            $query = $this->modelsManager->createQuery($phql);
//            $data = $this->modelsManager->createQuery($phql)->execute()->toArray();
            var_dump($data);
            die;
//            return $this->getModelsManager()->executeQuery($phql)->toArray();
        } catch (Exception $e) {
            var_dump($e);
            die;
            return false;
        }
    }

    public function updateUsers()
    {
        try {
            $phql = "UPDATE App\Model\User SET emp_kana_nm='khoa' WHERE del_flg=0 AND id=1";
            return $this->getModelsManager()->executeQuery($phql);
        } catch (Exception $e) {
            return false;
        }
    }

}
