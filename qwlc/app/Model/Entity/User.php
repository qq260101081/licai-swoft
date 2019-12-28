<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 用户表
 * Class User
 *
 * @since 2.0
 *
 * @Entity(table="user")
 */
class User extends Model
{
    protected const CREATED_AT = 'create_time';
    protected const UPDATED_AT = 'update_time';

    /**
     * 主键ID
     * @Id(incrementing=false)
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 用户名
     *
     * @Column()
     *
     * @var string
     */
    private $username;

    /**
     * 名字
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 手机
     *
     * @Column()
     *
     * @var string
     */
    private $phone;

    /**
     * 登录密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 交易密码
     *
     * @Column(name="trans_password", prop="transPassword")
     *
     * @var string
     */
    private $transPassword;

    /**
     * 用户资产
     *
     * @Column()
     *
     * @var int
     */
    private $amount;

    /**
     * 收益
     *
     * @Column()
     *
     * @var int
     */
    private $income;

    /**
     * 银行卡号
     *
     * @Column(name="bank_no", prop="bankNo")
     *
     * @var string
     */
    private $bankNo;

    /**
     * 0正常1禁用
     *
     * @Column()
     *
     * @var int
     */
    private $status;

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
     * 最后登录时间
     *
     * @Column(name="last_login_time", prop="lastLoginTime")
     *
     * @var int
     */
    private $lastLoginTime;


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
     * @param string $username
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $phone
     *
     * @return void
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $transPassword
     *
     * @return void
     */
    public function setTransPassword(string $transPassword): void
    {
        $this->transPassword = $transPassword;
    }

    /**
     * @param int $amount
     *
     * @return void
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param int $income
     *
     * @return void
     */
    public function setIncome(int $income): void
    {
        $this->income = $income;
    }

    /**
     * @param string $bankNo
     *
     * @return void
     */
    public function setBankNo(string $bankNo): void
    {
        $this->bankNo = $bankNo;
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
     * @param int $lastLoginTime
     *
     * @return void
     */
    public function setLastLoginTime(int $lastLoginTime): void
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getTransPassword(): ?string
    {
        return $this->transPassword;
    }

    /**
     * @return int
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getIncome(): ?int
    {
        return $this->income;
    }

    /**
     * @return string
     */
    public function getBankNo(): ?string
    {
        return $this->bankNo;
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

    /**
     * @return int
     */
    public function getLastLoginTime(): ?int
    {
        return $this->lastLoginTime;
    }

}
