<?php declare(strict_types=1);


namespace App\Rpc\Lib;

/**
 * Class WithdrawInterface
 *
 * @since 2.0
 */
interface WithdrawInterface
{
    /**
     * 用户提现列表
     *
     * @param int $user_id
     * @param int $page
     * @return array
     */
    public function pageByUser(int $user_id, int $page): array;

    /**
     * 创建一条提现记录
     *
     * @param int $user_id
     * @param $amount
     * @return array
     */
    public function create(int $user_id, $amount): array;
}