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
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=true,options={"comment":"排序"})
     */
    private $sort = '100';

    /**
     * @var integer
     *
     * @ORM\Column(name="tid", type="integer", nullable=true,options={"comment":"类型id"})
     */
    private $tid = '0';

    /**
     * @var integer
     * @ORM\Column(name="state", type="integer", nullable=true,options={"comment":"状态"})
     */
    private $state = 1;

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

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return GoodsTypeAttr
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set tid
     *
     * @param integer $tid
     *
     * @return GoodsTypeAttr
     */
    public function setTid($tid)
    {
        $this->tid = $tid;

        return $this;
    }

    /**
     * Get tid
     *
     * @return integer
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return GoodsTypeAttr
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
     * Set state
     *
     * @param integer $state
     *
     * @return GoodsTypeAttr
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }
}
