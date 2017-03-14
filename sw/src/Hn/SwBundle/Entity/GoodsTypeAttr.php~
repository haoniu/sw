<?php

namespace Hn\SwBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoodsTypeAttr
 *
 * @ORM\Table(name="goods_type_attr")
 * @ORM\Entity(repositoryClass="Hn\SwBundle\Repository\GoodsTypeAttrRepository")
 */
class GoodsTypeAttr
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
     * @ORM\Column(name="attr_name", type="string", length=255)
     */
    private $attrName;

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
     * Set attrName
     *
     * @param string $attrName
     *
     * @return GoodsTypeAttr
     */
    public function setAttrName($attrName)
    {
        $this->attrName = $attrName;

        return $this;
    }

    /**
     * Get attrName
     *
     * @return string
     */
    public function getAttrName()
    {
        return $this->attrName;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     *
     * @return GoodsTypeAttr
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
     * @return GoodsTypeAttr
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
