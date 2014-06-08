<?php
/**
 * @author Neeke.Gao
 * Date: 14-6-6 下午3:13
 */
class AlertSpall
{
    /**
     * 根据key生成option选中状态
     * @param $aOptions
     * @param null $selected
     * @return string
     */
    static public function mkOptionSelectedByKey($aOptions, $selected = NULL)
    {
        $str = '';
        foreach ($aOptions as $key => $value) {
            $str .= '<option value="' . $value . '"';
            if ($key == $selected) {
                $str .= ' selected';
            }

            $str .= '>';
            $str .= $key;
            $str .= '</option>';
        }

        return $str;
    }

    /**
     * 根据value生成option选中状态
     * @param $aOptions
     * @param null $selected
     * @return string
     */
    static public function mkOptionSelectedByValue($aOptions, $selected = NULL)
    {
        $str = '';
        foreach ($aOptions as $key => $value) {
            $str .= '<option value="' . $value . '"';
            if ($value == $selected) {
                $str .= ' selected';
            }

            $str .= '>';
            $str .= $key;
            $str .= '</option>';
        }

        return $str;
    }
}