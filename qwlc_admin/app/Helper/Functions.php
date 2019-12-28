<?php

use Firebase\JWT\JWT;
use Swoft\Http\Message\Response;
use Swoft\Http\Message\ContentType;
use Swoft\Context\Context;
use Swoft\Redis\Redis;

/**
 * 公共信息返回
 * @param array $data
 * @param int $code
 * @param string $msg
 * @param int $status
 * @return Response
 * @throws ReflectionException
 * @throws \Swoft\Bean\Exception\ContainerException
 */
function response($data = [], int $code = 0, string $msg = '', int $status = 200): Response
{
    $responseData = ['code' => $code, 'msg' => $msg?:Swoft::t("apiMsg.{$code}", [], 'zh'), 'data' => $data];
    return Context::get()
        ->getResponse()
        ->withStatus($status)
        ->withContentType(ContentType::JSON, 'utf-8')
        ->withData($responseData);
}

/**
 * 获取当前用户ID
 *
 * @return bool|mixed|Response
 * @throws ReflectionException
 * @throws \Swoft\Bean\Exception\ContainerException
 */
function getUserId()
{
    $accessToken = Context::get()->getRequest()->getHeaderLine("Authorization");

    $decoded = (array)JWT::decode($accessToken, env('JWT_KEY'), [env('JWT_ALG')]);

    if (!isset($decoded['data']))
    {
        return \response([], 2);
    }

    return $decoded['data']->user_id;
}

/**
 * 获取当前管理员ID
 *
 * @return bool|mixed|Response
 * @throws ReflectionException
 * @throws \Swoft\Bean\Exception\ContainerException
 */
function getAdminId()
{
    $accessToken = Context::get()->getRequest()->getHeaderLine("Authorization");

    $decoded = (array)JWT::decode($accessToken, env('JWT_KEY'), [env('JWT_ALG')]);

    if (!isset($decoded['data']))
    {
        return \response([], 2);
    }

    return $decoded['data']->admin_id;
}

/**
 * 金额单位分转换为元
 *
 * @param $money
 * @return string
 */
function moneyFormat($money)
{
    return number_format($money / 100, 2);
}

/**
 * 金额单位元转换为分
 *
 * @param $money
 * @return string
 */
function yuanToCent($money)
{
    return $money * 100;
}