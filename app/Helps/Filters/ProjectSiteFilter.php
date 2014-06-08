<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-29 下午3:31
 */
class Filters_ProjectSiteFilter extends Filters_BaseFilter
{
    public function filter()
    {

        $rules = array(
            'site_name'   => 'required|min:3|max:20',
            'site_domain' => 'required|active_url',
        );

        parent::valid($rules);
    }
}