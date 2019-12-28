<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 项目表
 * Class Product
 *
 * @since 2.0
 *
 * @Entity(table="product")
 */
class Product extends Model
{
    const CREATED_AT = "create_time";
    const UPDATED_AT = "update_time";

    /**
     * 主键
     * @Id()
     * @Column(name="product_id", prop="productId")
     *
     * @var int
     */
    private $productId;

    /**
     * 名称
     *
     * @Column()
     *
     * @var string|null
     */
    private $name;

    /**
     * 描述
     *
     * @Column()
     *
     * @var string|null
     */
    private $info;

    /**
     * 内容
     *
     * @Column()
     *
     * @var string|null
     */
    private $content;

    /**
     * 状态0正常
     *
     * @Column()
     *
     * @var int|null
     */
    private $status;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int|null
     */
    private $createTime;

    /**
     * 更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;


    /**
     * @param int $productId
     *
     * @return void
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string|null $info
     *
     * @return void
     */
    public function setInfo(?string $info): void
    {
        $this->info = $info;
    }

    /**
     * @param string|null $content
     *
     * @return void
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param int|null $status
     *
     * @return void
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
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
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
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
