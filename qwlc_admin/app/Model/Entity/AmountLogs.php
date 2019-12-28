<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 用户金额操作日志
 * Class AmountLogs
 *
 * @since 2.0
 *
 * @Entity(table="amount_logs")
 */
class AmountLogs extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 
     * @Id()
     * @Column(name="amount_logs_id", prop="amountLogsId")
     *
     * @var int
     */
    private $amountLogsId;

    /**
     * 
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int|null
     */
    private $userId;

    /**
     * 金额单位分
     *
     * @Column()
     *
     * @var int|null
     */
    private $amount;

    /**
     * 0后台加钱1后台减钱
     *
     * @Column()
     *
     * @var int|null
     */
    private $type;

    /**
     * 
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int|null
     */
    private $createTime;

    /**
     * 
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;


    /**
     * @param int $amountLogsId
     *
     * @return void
     */
    public function setAmountLogsId(int $amountLogsId): void
    {
        $this->amountLogsId = $amountLogsId;
    }

    /**
     * @param int|null $userId
     *
     * @return void
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param int|null $amount
     *
     * @return void
     */
    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param int|null $type
     *
     * @return void
     */
    public function setType(?int $type): void
    {
        $this->type = $type;
    }

    /**
     * @param int|null $createTime
     *
     * @return void
     */
    public function setCreateTime(?int $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @param int|null $updateTime
     *
     * @return void
     */
    public function setUpdateTime(?int $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @return int
     */
    public function getAmountLogsId(): ?int
    {
        return $this->amountLogsId;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return int|null
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

}
