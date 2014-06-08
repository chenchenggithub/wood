<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-23 下午4:06
 */
class DomainMenuEnum
{
    static $boardMenus = array(
        'overview' => array(
            'tpl'   => 'project.board.overview',
            'url'   => '/site/board/overview/',
            'label' => '概览',
        ),
        'net'      => array(
            'tpl'   => 'project.board.net',
            'url'   => '/site/board/net/',
            'label' => '网络',
        ),
        'page'     => array(
            'tpl'   => 'project.board.page',
            'url'   => '/site/board/page/',
            'label' => '网页',
        ),
        'alert'    => array(
            'tpl'   => 'project.board.alert',
            'url'   => '/site/board/alert/',
            'label' => '报警',
        ),
        'report'   => array(
            'tpl'   => 'project.board.report',
            'url'   => '/site/board/report/',
            'label' => '报告',
        ),
        'setting'  => array(
            'tpl'   => 'project.board.setting',
            'url'   => '/site/board/setting/',
            'label' => '设置',
        ),
    );
}