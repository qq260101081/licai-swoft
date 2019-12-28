<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 利息日志表
 * Class ProfitLogs
 *
 * @since 2.0
 *
 * @Entity(table="profit_logs")
 */
class ProfitLogs extends Model
{
    /**
     * 
     * @Id()
     * @Column(name="profit_logs_id", prop="profitLogsId")
     *
     * @var int
     */
    private $profitLogsId;

    /**
     * 利息（单位:分）
     *
     * @Column()
     *
     * @var int
     */
    private $point;

    /**
     * 最后的金额统计（单位:分）
     *
     * @Column(name="amount_total", prop="amountTotal")
     *
     * @var int
     */
    private $amountTotal;

    /**
     * 用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 下级用户ID
     *
     * @Column(name="lower_user_id", prop="lowerUserId")
     *
     * @var int
     */
    private $lowerUserId;

    /**
     * 收益类型0本金1团队
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int
     */
    private $updateTime;


    /**
     * @param int $profitLogsId
     *
     * @return void
     */
    public function setProfitLogsId(int $profitLogsId): void
    {
        $this->profitLogsId = $profitLogsId;
    }

    /**
     * @param int $point
     *
     * @return void
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    /**
     * @param int $amountTotal
     *
     * @return void
     */
    public function setAmountTotal(int $amountTotal): void
    {
        $this->amountTotal = $amountTotal;
    }

    /**
     * @param int $userId
     *
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param int $lowerUserId
     *
     * @return void
     */
    public function setLowerUserId(int $lowerUserId): void
    {
        $this->lowerUserId = $lowerUserId;
    }

    /**
     * @param int $type
     *
     * @return void
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @param int $createTime
     *
     * @return void
     */
    public function setCreateTime(int $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @param int $updateTime
     *
     * @return void
     */
    public function setUpdateTime(int $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @return int
     */
    public function getProfitLogsId(): ?int
    {
        return $this->profitLogsId;
    }

    /**
     * @return int
     */
    public function getPoint(): ?int
    {
        return $this->point;
    }

    /**
     * @return int
     */
    public function getAmountTotal(): ?int
    {
        return $this->amountTotal;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getLowerUserId(): ?int
    {
        return $this->lowerUserId;
    }

    /**
     * @return int
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return int
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

}
