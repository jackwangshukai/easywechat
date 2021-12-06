<?php
/**
 * Created by PhpStorm.
 * User: wangshukai
 * Date: 2021/3/8
 * Time: 1:40 PM
 */

namespace EasyWeChat\MiniProgram\Transaction\AfterSale;

use EasyWeChat\Core\Exceptions\HttpException;
use EasyWeChat\MiniProgram\Core\AbstractMiniProgram;

use EasyWeChat\Core\Exceptions\InvalidArgumentException;

class AfterSale extends AbstractMiniProgram
{
    const API_POST_SHOP_ADD = 'https://api.weixin.qq.com/shop/aftersale/add';
    const API_POST_SHOP_GET = 'https://api.weixin.qq.com/shop/aftersale/get';
    const API_POST_SHOP_UPDATE = 'https://api.weixin.qq.com/shop/aftersale/update';

    public function add(string $outOrderId, string $outAfterSaleId, string $openId, int $type, string $createTime, int $status, int $finishAllAfterSale, string $path, array $productInfos)
    {
        $params = [
            "out_order_id" => $outOrderId,
            "out_aftersale_id" => $outAfterSaleId,
            "openid" => $openId,
            "type" => $type,
            "create_time" => $createTime,
            "status" => $status,
            "finish_all_aftersale" => $finishAllAfterSale,
            "path" => $path,
            "product_infos" => $productInfos,
        ];
        return $this->getStream(self::API_POST_SHOP_ADD, $params);
    }

    public function get(string $orderId, string $outOrderId, string $openId)
    {
        $params = [
            "order_id" => $orderId,
            "out_order_id" => $outOrderId,
            "openid" => $openId,
        ];
        return $this->getStream(self::API_POST_SHOP_GET, $params);
    }

    public function update(string $outOrderId, string $orderId, string $outAfterSaleId, int $status, int $finishAllAfterSale)
    {
        $params = [
            "order_id" => $orderId,
            "out_order_id" => $outOrderId,
            "out_aftersale_id" => $outAfterSaleId,
            "status" => $status,
            "finish_all_aftersale" => $finishAllAfterSale,
        ];
        return $this->getStream(self::API_POST_SHOP_UPDATE, $params);
    }

    /**
     * Get stream.
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function getStream($endpoint, $params)
    {
        return json_decode(strval($this->getHttp()
            ->json($endpoint, $params)->getBody()), true);
    }
}