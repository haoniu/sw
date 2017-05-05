<?php

namespace Hn\SwBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoodsType
 *
 * @ORM\Table(name="goods_type")
 * @ORM\Entity(repositoryClass="Hn\SwBundle\Repository\GoodsTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class GoodsType
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
     * @ORM\Column(name="type_name", type="string", length=255)
     */
    private $typeName;

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
     * @ORM\OneToOne(targetEntity="GoodsCategory",mappedBy="goodsType")
     */
    private $goodsCategory;

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
     * Set typeName
     *
     * @param string $typeName
     *
     * @return GoodsType
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * Get typeName
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     *
     * @return GoodsType
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
     * @return GoodsType
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
     * @return GoodsType
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
     * Set state
     *
     * @param integer $state
     *
     * @return GoodsType
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

    /**
     * Set goodsCategory
     *
     * @param \Hn\SwBundle\Entity\GoodsCategory $goodsCategory
     *
     * @return GoodsType
     */
    public function setGoodsCategory(\Hn\SwBundle\Entity\GoodsCategory $goodsCategory = null)
    {
        $this->goodsCategory = $goodsCategory;

        return $this;
    }

    /**
     * Get goodsCategory
     *
     * @return \Hn\SwBundle\Entity\GoodsCategory
     */
    public function getGoodsCategory()
    {
        return $this->goodsCategory;
    }
}
