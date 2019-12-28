<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 下级关系表
 * Class LowerRelation
 *
 * @since 2.0
 *
 * @Entity(table="lower_relation")
 */
class LowerRelation extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 
     * @Id(incrementing=false)
     * @Column(name="lower_relation_id", prop="lowerRelationId")
     *
     * @var int
     */
    private $lowerRelationId;

    /**
     * 用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 下级ID
     *
     * @Column(name="lower_user_id", prop="lowerUserId")
     *
     * @var int
     */
    private $lowerUserId;

    /**
     * 几级关系
     *
     * @Column()
     *
     * @var int
     */
    private $level;

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
     * @param int $lowerRelationId
     *
     * @return void
     */
    public function setLowerRelationId(int $lowerRelationId): void
    {
        $this->lowerRelationId = $lowerRelationId;
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
     * @param int $level
     *
     * @return void
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
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
    public function getLowerRelationId(): ?int
    {
        return $this->lowerRelationId;
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
    public function getLevel(): ?int
    {
        return $this->level;
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
