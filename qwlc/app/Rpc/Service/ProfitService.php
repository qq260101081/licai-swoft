<?php declare(strict_types=1);


namespace App\Rpc\Service;


use App\Model\Logic\ProfitLogic;
use App\Rpc\Lib\ProfitInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class ProfitService
 *
 * @since 2.0
 * @Service()
 */
class ProfitService implements ProfitInterface
{
    /**
     * @Inject()
     * @var ProfitLogic
     */
    private $_logic;

    /**
     * @param int $user_id
     * @param int $page
     * @return array
     */
    public function pageByUser(int $user_id, int $page): array
    {
        return $this->_logic->getPageByUser($user_id, $page);
    }

    public function create(array $data): bool
    {
        // TODO: Implement create() method.
    }
}