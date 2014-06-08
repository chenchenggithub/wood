<?php

class BaseController extends Controller
{

    protected $params = NULL;

    protected $layout = 'layouts.master';

    /**
     * @var RESTService
     */
    protected $rest = NULL;

    /**
     * @var CacheService
     */
    protected $cache = NULL;

    /**
     * @var VO_Response_UserCache
     */
    protected $userInfo = NULL;

    public function __construct()
    {
        $this->rest   = RESTService::instance();
        $this->cache  = CacheService::instance();
        $this->params = Input::all();
    }

    protected function getParam($sParamKey)
    {
        if (array_key_exists($sParamKey, $this->params)) return $this->params[$sParamKey];
        return Route::input($sParamKey);
    }

    /**
     * @return VO_Response_UserCache
     */
    protected function getUserInfo()
    {
        if (is_null($this->userInfo)) {
            $this->userInfo = UserService::getUserCache();
        }

        return $this->userInfo;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * @param $template
     * @param string $spall
     * @return mixed
     */
    protected function view($template, $spall = 'content')
    {
        $oUserCache             = UserService::getUserCache();
        $this->layout->$spall   = View::make($template);
        $this->layout->tsb_left = View::make('layouts.tsb_left')->with(array(
            'leftMenus' => UserMenuEnum::getLeftMenu($oUserCache->role_right),
        ));
        return $this->layout->$spall;
    }

    /**
     * @param $template
     * @param string $spall
     * @return mixed
     */
    protected function viewAjax($template, $spall = 'content')
    {
        $this->layout         = View::make('layouts.ajax_master');
        $this->layout->$spall = View::make($template);
        return $this->layout->$spall;
    }

    /**
     * @param $template
     * @param string $spall
     * @return mixed
     */
    protected function viewAdmin($template, $spall = 'content')
    {
        //获取menu
        $menus = AdminService::instance()->getRightMenu();
        //获取admin信息
        $info                 = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
        $this->layout         = View::make('layouts.admin_master');
        $this->layout->$spall = View::make($template)->with(array(
            'menus' => $menus,
            'info'  => $info,
        ));
        return $this->layout->$spall;
    }


    /**
     * 业务验证错误信息
     * @param array $validator_rule 验证规则
     * @param array $error_message 错误编号
     * @return mixed
     */
    protected function validatorError(array $validator_rule, array $error_message)
    {
        foreach ($validator_rule as $filed => $rules) {
            if (!is_array($rules)) {
                $rules = explode('|', $rules);
            }
            foreach ($rules as $key => $rule) {
                $validator = Validator::make(array($filed => Input::get($filed)), array($filed => $rule));
                if ($validator->fails()) {
                    $this->rest->error(NULL, $error_message[$filed][$key]);
                }
            }
        }
        return TRUE;
    }

    /**
     * 业务错误信息
     * @param $code
     * @return mixed
     */
    protected function professionError($code)
    {
        $this->rest->error(NULL, $code);
    }
}
