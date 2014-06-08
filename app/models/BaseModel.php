<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-5-8 上午10:20
 *
 *
 * demo
 *
 *
 * 1: create a model
 * class User_UserAccountModel extends BaseModel
 * {
 *  protected $table = 'account_info';
 *  protected $primaryKey = 'account_id';
 * }
 *
 * 2: use the model
 * UserService:
 * $this->mUserAccountModel = new User_UserAccountModel();
 *
 * $aWhere = array(
 *  'account_id in ?' => $accout_ids,
 * );
 *
 * $aUpdate = array(
 * 'account_status' => $iStatus,
 * );
 *
 * return $this->mUserAccountModel->update($aUpdate, $aWhere);
 *
 * 3: done
 *
 *
 */
class BaseModel
{

    protected $table = '';
    protected $primaryKey = '';
    protected $select = array();
    protected $offset = NULL;
    protected $limit = NULL;

    protected static $transactionsCount = 0;

    public function __construct()
    {

    }

    /**
     * 开启只使用主库
     */
    public function useMasterOn()
    {

    }

    /**
     * 关闭只使用主库
     */
    public function useMasterOff()
    {

    }

    public function getTableName()
    {
        return $this->table;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param array $aSelect
     */
    public function setSelect(array $aSelect)
    {
        $this->select = $aSelect;
    }

    public function removeSelect()
    {
        $this->select = null;
    }

    /**
     * @param $oQuery
     * @return mixed
     */
    public function getSelect(&$oQuery)
    {
        if (count($this->select) < 1) return $oQuery;

        foreach ($this->select as $column) {
            $oQuery->addSelect($column);
        }

        return $oQuery;
    }

    /**
     * 创建where条件
     * @param $oQuery
     * @param array $aWhere
     * @internal param array $request
     * @return array
     */
    public function mkWhere(&$oQuery, array $aWhere = array())
    {
        if (count($aWhere) < 1) return $oQuery;

        foreach ($aWhere as $column => $val) {
            $valType     = gettype($val);
            $lowerColumn = strtolower($column);

            if ($valType == 'array') {
                foreach (SQLKeyReToFunction::$strToWhereFunctionForArray as $strKey => $function) {
                    if (strstr($lowerColumn, $strKey)) {
                        $oQuery->{$function}(self::getRealColumn($lowerColumn, $strKey), $val);
                        break;
                    }
                }

            } else {
                if (!strstr($lowerColumn, '?')) {
                    $oQuery->where($lowerColumn, $val);
                    continue;
                }

                foreach (SQLKeyReToFunction::$strToWhereFunctionForNormal as $strKey => $function) {
                    if (strstr($lowerColumn, $strKey)) {
                        if ($function == 'whereNull') {
                            $oQuery->whereNull(self::getRealColumn($lowerColumn, $strKey));
                        } else {
                            $oQuery->where(self::getRealColumn($lowerColumn, $strKey), trim($strKey), $val);
                        }

                        break;
                    }
                }
            }
        }

        return $oQuery;
    }

    /**
     * 简单的orWhere组装
     * @param $oQuery
     * @param array $aOrWhere
     * @return mixed
     */
    public function mkOrWhere(&$oQuery, array $aOrWhere = array())
    {
        if (count($aOrWhere) < 1) return $oQuery;

        foreach ($aOrWhere as $column => $val) {
            $valType     = gettype($val);
            $lowerColumn = strtolower($column);

            if ($valType == 'array') {
                foreach (SQLKeyReToFunction::$strToWhereFunctionForArray as $strKey => $function) {
                    if (strstr($lowerColumn, $strKey)) {
                        $oQuery->{'or' . $function}(self::getRealColumn($lowerColumn, $strKey), $val);
                        break;
                    }
                }

            } else {
                if (!strstr($lowerColumn, '?')) {
                    $oQuery->where($lowerColumn, $val);
                    continue;
                }

                foreach (SQLKeyReToFunction::$strToWhereFunctionForNormal as $strKey => $function) {
                    if (strstr($lowerColumn, $strKey)) {
                        if ($function == 'whereNull') {
                            $oQuery->orWhereNull(self::getRealColumn($lowerColumn, $strKey));
                        } else {
                            $oQuery->orWhere(self::getRealColumn($lowerColumn, $strKey), trim($strKey), $val);
                        }

                        break;
                    }
                }
            }
        }

        return $oQuery;
    }

    /**
     * 组装order
     * @param $oQuery
     * @param array $aOrder
     * @return mixed
     */
    public function mkOrder(&$oQuery, array $aOrder = array())
    {
        if (count($aOrder) < 1) return $oQuery;

        foreach ($aOrder as $key => $val) {
            $oQuery->orderBy($key, $val);
        }

        return $oQuery;
    }


    /**
     * 设置limit
     * @param $offset
     * @param $limit
     */
    public function setLimit($offset, $limit)
    {
        if (is_numeric($offset) && $offset >= 0) $this->offset = $offset;
        if (is_numeric($limit) && $limit > 0) $this->limit = $limit;
    }

    /**
     * 组装limit
     * @param $oQuery
     * @return mixed
     */
    public function getLimit(&$oQuery)
    {

        if (is_null($this->offset) || is_null($this->limit)) return $oQuery;
        return $oQuery->skip($this->offset)->take($this->limit);
    }

    /**
     * 检测是否存在
     * @param int|array $iPrimaryKeyOraWhere
     * @return bool
     */
    public function exists($iPrimaryKeyOraWhere)
    {
        switch (gettype($iPrimaryKeyOraWhere)) {
            case 'array':
                $oQuery = DB::table($this->table)->select($this->primaryKey);
                if (count($iPrimaryKeyOraWhere) > 0) {
                    self::mkWhere($oQuery, $iPrimaryKeyOraWhere);
                }
                $result = $oQuery->first();
                unset($oQuery);
                break;
            default:
                $result = DB::select('select ' . $this->primaryKey . ' from ' . $this->table . ' where ' . $this->primaryKey . ' = ?', array((int)$iPrimaryKeyOraWhere));
                break;
        }

        if ($result) return TRUE;

        return FALSE;
    }

    /**
     * 插入数据
     * @param array $aData
     * @return int
     */
    public function insert(array $aData)
    {
        if (count($aData) < 1) return FALSE;
        if (is_array(reset($aData))) {
            return DB::table($this->table)->insert($aData);
        }
        return DB::table($this->table)->insertGetId($aData);
    }

    /**
     * 依条件更新
     * @param array $aData
     * @param int|array $iPrimaryKeyOraWhere
     * @return bool
     */
    public function update(array $aData, $iPrimaryKeyOraWhere)
    {
        if (count($aData) < 1) return FALSE;

        $oQuery = DB::table($this->table);

        switch (gettype($iPrimaryKeyOraWhere)) {
            case 'array':
                self::mkWhere($oQuery, $iPrimaryKeyOraWhere);
                break;
            default:
                $oQuery->where($this->primaryKey, (int)$iPrimaryKeyOraWhere);
        }
        return $oQuery->update($aData);
    }

    /**
     * 依条件删除
     * @param array $aWhere
     * @return int
     */
    public function delete(array $aWhere)
    {
        if (count($aWhere) < 1) return FALSE;

        $oQuery = DB::table($this->table);
        self::mkWhere($oQuery, $aWhere);
        return $oQuery->delete();
    }

    /**
     * 依条件取得count值
     * @param array $aWhere
     * @return int
     */
    public function count(array $aWhere)
    {
        $oQuery = DB::table($this->table)->select($this->primaryKey);
        if (count($aWhere) >= 1) {
            self::mkWhere($oQuery, $aWhere);
        }

        $result = $oQuery->count();

        return $result;
    }

    /**
     * 依主键或条件，取得单条数据
     * 非数组且为int值时，判断为主键条件
     * @param $iPrimaryKeyOraWhere
     * @return array
     */
    public function fetchRow($iPrimaryKeyOraWhere)
    {
        switch (gettype($iPrimaryKeyOraWhere)) {
            case 'array':
                $oQuery = DB::table($this->table);
                if (count($iPrimaryKeyOraWhere) > 0) {
                    self::mkWhere($oQuery, $iPrimaryKeyOraWhere);
                }
                self::getSelect($oQuery);
                $result = $oQuery->first();
                unset($oQuery);
                break;
            default:
                if (is_array($this->select)) {
                    $select_items = $this->select ? implode(',', $this->select) : '*';
                } else {
                    $select_items = '*';
                }
                $result = DB::select('select ' . $select_items . ' from ' . $this->table . ' where ' . $this->primaryKey . ' = ?', array((int)$iPrimaryKeyOraWhere));
                break;
        }

        if (is_null($result) || is_object($result)) return $result;

        if (array_key_exists(0, $result)) return $result[0];

        return $result;
    }

    /**
     * 依条件取得多条数据
     * @param array $aWhere
     * @param array $aOrWhere
     * @param array $aOrder
     * @return array
     */
    public function fetchAll(array $aWhere = array(), array $aOrWhere = array(), array $aOrder = array())
    {
        $oQuery = DB::table($this->table);

        self::getSelect($oQuery);

        if (count($aWhere) > 0) {
            self::mkWhere($oQuery, $aWhere);
        }

        if (count($aOrWhere) > 0) {
            self::mkOrWhere($oQuery, $aOrWhere);
        }

        self::getLimit($oQuery);

        if (count($aOrder) < 1) {
            $aOrder = array(
                $this->primaryKey => 'desc',
            );
        }

        if (count($aOrder) > 0) {
            self::mkOrder($oQuery, $aOrder);
        }

        $result = $oQuery->get();

        return $result;
    }

    /**
     * 开启事务
     */
    public static function transStart()
    {
        ++self::$transactionsCount;

        if (self::$transactionsCount == 1) {
            DB::beginTransaction();
        }
    }

    /**
     * 结束事务
     */
    public static function transCommit()
    {
        if (self::$transactionsCount == 1) DB::commit();

        --self::$transactionsCount;
    }

    /**
     * 回滚事务
     */
    public static function transRollBack()
    {
        if (self::$transactionsCount == 1) {
            self::$transactionsCount = 0;

            DB::rollBack();
        } else {
            --self::$transactionsCount;
        }
    }

    static private function getRealColumn($column, $str_key)
    {
        return trim(str_replace(array('?', $str_key), array('', ''), $column));
    }
}