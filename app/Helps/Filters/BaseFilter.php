<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-29 下午3:36
 */
class Filters_BaseFilter
{
    protected $params;

    /**
     * @var RESTService
     */
    protected $rest;

    public function __construct()
    {
        $this->params = Input::all();
        $this->rest   = RESTService::instance();
    }

    /**
     * @param $rules
     * @param array $messages
     * @throws Exception
     *
     * @todo 自定义messages
     */
    protected function valid($rules, $messages = array())
    {
        $validator = Validator::make($this->params, $rules, $messages);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first(), ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST);
        }
    }
}