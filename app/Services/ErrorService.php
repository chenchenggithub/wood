<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-9 下午2:17
 *
 * demo
 *
 * 1: thow a new exception
 * M || C || S
 * throw new Exception('',ErrorCodeEnum::STATUS_ERROR_API_VALIDE_TIME);
 *
 * 2: dispatch the closest exception
 * app/start/global.php
 * ErrorService::instance()->setError($exception, $code);
 * return ErrorService::instance()->dispatchError();
 *
 */
class ErrorService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return ErrorService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    private $errorCode;
    private $errorMsg;

    /**
     * @todo log it
     *
     * @param Exception $exception
     * @param $code
     */
    public function setError(Exception $exception, $code)
    {
        $iExceptionCode = $exception->getCode();
        $sExceptionMsg  = $exception->getMessage();

        if (!empty($iExceptionCode)) {
            $code = $iExceptionCode;
        }

        if (empty($sExceptionMsg)) {
            $aErrorCodes = ErrorCodeEnum::getCodes() + ProfessionErrorCodeEnum::getErrorMessage();
            if (array_key_exists($code, $aErrorCodes)) {
                $sExceptionMsg = $aErrorCodes[$code];
            }
        }

        $this->errorCode = $code;
        $this->errorMsg  = $sExceptionMsg;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * @return mixed
     */
    public function dispatchError()
    {
        if (Request::ajax()) {
            RESTService::instance()->error($this->errorMsg, $this->errorCode);
        } else {
            return Response::view('dispatch.responseError', array(), 404);
        }
    }
}
