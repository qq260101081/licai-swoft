<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 提现日志
 * Class WithdrawLogs
 *
 * @since 2.0
 *
 * @Entity(table="withdraw_logs")
 */
class WithdrawLogs extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 
     * @Id()
     * @Column(name="withdraw_logs_id", prop="withdrawLogsId")
     *
     * @var int
     */
    private $withdrawLogsId;

    /**
     * 
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 提现的金额（单位:分）
     *
     * @Column()
     *
     * @var int
     */
    private $point;

    /**
     * 提现前金额
     *
     * @Column(name="withdraw_before", prop="withdrawBefore")
     *
     * @var int
     */
    private $withdrawBefore;

    /**
     * 0提现中1失败2成功
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 提现申请提交时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 管理员处理时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int
     */
    private $updateTime;


    /**
     * @param int $withdrawLogsId
     *
     * @return void
     */
    public function setWithdrawLogsId(int $withdrawLogsId): void
    {
        $this->withdrawLogsId = $withdrawLogsId;
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
     * @param int $point
     *
     * @return void
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    /**
     * @param int $withdrawBefore
     *
     * @return void
     */
    public function setWithdrawBefore(int $withdrawBefore): void
    {
        $this->withdrawBefore = $withdrawBefore;
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
    public function getWithdrawLogsId(): ?int
    {
        return $this->withdrawLogsId;
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
    public function getPoint(): ?int
    {
        return $this->point;
    }

    /**
     * @return int
     */
    public function getWithdrawBefore(): ?int
    {
        return $this->withdrawBefore;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
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
