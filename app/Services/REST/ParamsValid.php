<?php
/**
 * 参数验证
 * @author Neeke.Gao
 */
class REST_ParamsValid extends BaseService
{
    private $haveValidedMustParams = FALSE;
    private $haveValidedCanParams = FALSE;

    /**
     * 必须具备的参数列表 少一不可
     * @var array
     */
    private $paramsMustMap = array();
    private $paramsMustToValid = array();

    /**
     * 可供选择的参数列表　不可超出范围
     * @var array
     */
    private $paramsCanMap = array();
    private $paramsCanToValid = array();


    /**
     * @var REST_ParamsValid
     */
    private static $self = NULL;

    /**
     * @static
     * @return REST_ParamsValid
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * 设置必须包含的值
     * @param array $data
     */
    public function setParamsMustMap(array $data)
    {
        $this->paramsMustMap = $data;
    }

    /**
     * 设置可以包含的值
     * @param array $data
     */
    public function setParamsCanMap(array $data)
    {
        $this->paramsCanMap = $data;
    }

    /**
     * 检测必须存在的参数是否合法　少一不可
     * @param array $data
     */
    public function ckParamsMustMap(array $data)
    {
        $this->paramsMustToValid = $data;
        self::validMustParams();
    }

    /**
     * 检测某些参数是否在可供访问的参数列表内　不可超出
     * @param array $data
     */
    public function ckParamsCanMap(array $data)
    {
        $this->paramsCanToValid = $data;
        self::validCanParams();
    }

    /**
     * 检查必须存在的params是否在合法范围　少一不可
     * @todo 添加合法化验证　目前只是检测是否存在
     */
    private function validMustParams()
    {
        foreach ($this->paramsMustMap as $v) {
            if ($this->haveValidedMustParams == FALSE && !isset($this->paramsMustToValid[$v])) {
                $this->haveValidedMustParams = TRUE;
                RESTService::instance()->error('api needs param ' . $v, ErrorCodeEnum::STATUS_ERROR_PARAMS);
            }
        }
    }

    /**
     * 检查params是否在可供访问的列表内　　不可超出范畴
     */
    private function validCanParams()
    {
        foreach ($this->paramsCanToValid as $k => $v) {
            if ($this->haveValidedCanParams == FALSE && !in_array($v, $this->paramsCanMap)) {
                $this->haveValidedCanParams = TRUE;
                RESTService::instance()->error('the param ' . $v . ' can not in', ErrorCodeEnum::STATUS_ERROR_PARAMS);
            }
        }
    }
}