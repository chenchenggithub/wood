<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-20
 * Time: 下午2:36
 */
class InvoiceTest extends TestCase{
    /**
     * 发票测试接口
     */
    public function testInstance(){
        $this->insertInvoice();
    }

    /**
     * 创建一个新的发票申请，并更改订单的状态
     */
    public function insertInvoice(){
        $insertData = new stdClass();
        $insertData->order_history_ids = array(35);
        $insertData->apply_time = null;
        $insertData->account_id = 1;
        $insertData->user_id = 1;
        $insertData->invoice_header = '北京云智慧';
        $insertData->contact = '陈诚';
        $insertData->telephone = '15625223554';
        $insertData->invoice_amount = '1999.00';
        $insertData->address = '北京海淀';
        $insertData->remark = '要快';
        $insertData->status = null;
        $insertData->zip_code = '2150200';

        if(!InvoiceService::instance()->insertInvoice($request_info)){
            $this->assertTrue(false);
            return false;
        }
        $this->assertTrue(true);

       /* $cookie_file = dirname(__FILE__).'/cookie.txt';
        //$cookie_file = tempnam("tmp","cookie");
        //先获取cookies并保存
        $url = "http://dev-chencheng.toushibao.com/invoice/apply";
        $ch = curl_init($url); //初始化
        curl_setopt($ch, CURLOPT_HEADER, 0); //不返回header部分
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，而非直接输出
        curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
        $get_data = curl_exec($ch);
        curl_close($ch);

        $post_data = array(
            'loginfield' => 'username',
            'username' => 'ybb',
            'password' => '123456',

        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://dev-chencheng.toushibao.com/invoice/dispose_apply');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 我们在POST数据！
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        //调试使用
        if ($output === FALSE) {
            echo "cURL Error: " . curl_error($ch);
        }
        curl_close($ch);
        var_dump($output);*/

    }
}