<?php declare(strict_types=1);


namespace App\Rpc\Lib;

/**
 * Class ProductInterface
 *
 * @since 2.0
 */
interface ProductInterface
{
    /**
     * 列表
     *
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array;

    /**
     * 获取一条
     *
     * @param int $id
     * @return array
     */
    public function detail(int $id): array;
}
