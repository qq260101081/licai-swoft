<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 配置表
 * Class Cfg
 *
 * @since 2.0
 *
 * @Entity(table="cfg")
 */
class Cfg extends Model
{
    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 图片访问域名
     *
     * @Column(name="img_domain", prop="imgDomain")
     *
     * @var string|null
     */
    private $imgDomain;


    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string|null $imgDomain
     *
     * @return void
     */
    public function setImgDomain(?string $imgDomain): void
    {
        $this->imgDomain = $imgDomain;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getImgDomain(): ?string
    {
        return $this->imgDomain;
    }

}
