<?php

/*
 * The file is part of the payment lib.
 *
 * (c) Leo <dayugog@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

date_default_timezone_set('Asia/Shanghai');
$wxConfig = require_once __DIR__ . '/../wxconfig.php';

$orderNo = time() . rand(1000, 9999);
// 订单信息
$payData = [
    'body'         => 'test body',
    'subject'      => 'test subject',
    'order_no'     => $orderNo,
    'time_expire'  => time() + 600, // 表示必须 600s 内付款
    'amount'       => '3.01', // 微信沙箱模式，需要金额固定为3.01
    'return_param' => '123',
    'client_ip'    => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1', // 客户地址
    'openid'       => 'ottkCuO1PW1Dnh6PWFffNk-2MPbY',
    'product_id'   => '123',

    // 如果是服务商，请提供以下参数
    'sub_appid'  => '', //微信分配的子商户公众账号ID
    'sub_mch_id' => '', // 微信支付分配的子商户号
    'sub_openid' => '', // 用户在子商户appid下的唯一标识
];

// 使用
try {
    $client = new \Payment\Client(\Payment\Client::WECHAT, $wxConfig);
    $res    = $client->pay(\Payment\Client::WX_CHANNEL_PUB, $payData);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
    exit;
} catch (\Payment\Exceptions\GatewayException $e) {
    echo $e->getMessage();
    exit;
} catch (\Payment\Exceptions\ClassNotFoundException $e) {
    echo $e->getMessage();
    exit;
}

var_dump($res);
