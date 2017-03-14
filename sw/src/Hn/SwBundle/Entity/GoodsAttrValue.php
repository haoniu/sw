<?php

namespace Hn\SwBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoodsAttrValue
 *
 * @ORM\Table(name="goods_attr_value")
 * @ORM\Entity(repositoryClass="Hn\SwBundle\Repository\GoodsAttrValueRepository")
 */
class GoodsAttrValue
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_time", type="integer", nullable=true,options={"comment":"创建时间"})
     */
    private $createTime = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="update_time", type="integer", nullable=true,options={"comment":"更新时间"})
     */
    private $updateTime = '0';

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return GoodsAttrValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     *
     * @return GoodsAttrValue
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set updateTime
     *
     * @param integer $updateTime
     *
     * @return GoodsAttrValue
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
