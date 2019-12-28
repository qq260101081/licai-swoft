<?php declare(strict_types=1);


namespace App\Rpc\Lib;

/**
 * Class UserInterface
 *
 * @since 2.0
 */
interface UserInterface
{
    /**
     * 我的页面
     *
     * @param int $user_id
     * @return array
     */
    public function info(int $user_id): array;

    /**
     * 修改信息
     *
     * @param array $data
     * @return array
     */
    public function update(array $data): array;

    /**
     * 我的团队列表
     *
     * @param int $user_id
     * @param int $level
     * @param int $page
     * @return array
     */
    public function teamList(int $user_id, int $level, int $page): array;

    /**
     * 用户团队人数统计
     * @param int $user_id
     * @return array
     */
    public function teamCount(int $user_id): array;
}