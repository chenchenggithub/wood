<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-6-4
 * Time: 下午5:13
 */

class ES_SiteDashboardService extends BaseService{
    static private $self = NULL;
    static private $es_db = NULL;
    static public function instance(){
        if(is_null(self::$self)){
            self::$self = new self();

        }
        return self::$self;
    }

    //实例ES的sdk
    public function __construct(){
            $params = Config::get('elasticsearch.elastic');
            self::$es_db = new Elasticsearch\Client($params);
    }

    //测试方法es
    public function testEs(){
        $searchParams['index'] = 'twitter';
        $searchParams['type']  = 'tweet';
        $searchParams['body']['query']['match']['testField'] = 'abc';
        $retDoc = self::$es_db->search($searchParams);
        var_dump($retDoc);
    }
} 