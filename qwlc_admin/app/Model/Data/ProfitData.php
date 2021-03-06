<?php declare(strict_types=1);


namespace App\Model\Data;

use App\Model\Dao\IncomeDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * @Bean()
 * Class ProfitData
 * @package App\Model\Data
 */
class ProfitData
{
    /**
     * @Inject()
     * @var IncomeDao
     */
    private $_profitDao;

    public function lastMonthProfit($user_id)
    {
        return $this->_profitDao->lastMonthProfit($user_id);
    }
}