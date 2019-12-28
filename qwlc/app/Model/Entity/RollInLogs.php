<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 转入日志
 * Class RollInLogs
 *
 * @since 2.0
 *
 * @Entity(table="roll_in_logs")
 */
class RollInLogs extends Model
{
    /**
     * 
     * @Id()
     * @Column(name="roll_in_logs_id", prop="rollInLogsId")
     *
     * @var int
     */
    private $rollInLogsId;

    /**
     * 
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 转入的金额（单位:分）
     *
     * @Column()
     *
     * @var int
     */
    private $point;

    /**
     * 转入前金额
     *
     * @Column(name="roll_in_before", prop="rollInBefore")
     *
     * @var int
     */
    private $rollInBefore;

    /**
     * 转入后金额
     *
     * @Column(name="roll_in_last", prop="rollInLast")
     *
     * @var int
     */
    private $rollInLast;

    /**
     * 0转入中1失败2成功
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 转入申请提交时间
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
     * @param int $rollInLogsId
     *
     * @return void
     */
    public function setRollInLogsId(int $rollInLogsId): void
    {
        $this->rollInLogsId = $rollInLogsId;
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
     * @param int $rollInBefore
     *
     * @return void
     */
    public function setRollInBefore(int $rollInBefore): void
    {
        $this->rollInBefore = $rollInBefore;
    }

    /**
     * @param int $rollInLast
     *
     * @return void
     */
    public function setRollInLast(int $rollInLast): void
    {
        $this->rollInLast = $rollInLast;
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
    public function getRollInLogsId(): ?int
    {
        return $this->rollInLogsId;
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
    public function getRollInBefore(): ?int
    {
        return $this->rollInBefore;
    }

    /**
     * @return int
     */
    public function getRollInLast(): ?int
    {
        return $this->rollInLast;
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
