<?php declare(strict_types=1);


namespace App\Rpc\Lib;

/**
 * Class ProfitInterface
 *
 * @since 2.0
 */
interface ProfitInterface
{
    /**
     * 用户收益列表
     *
     * @param int $user_id
     * @param int $page
     * @return array
     */
    public function pageByUser(int $user_id, int $page): array;

    /**
     * 创建一条收益
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool;
}