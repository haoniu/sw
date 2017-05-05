<?php
namespace Hn\SwBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="goods_category")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 */
class GoodsCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(length=64)
     */
    private $title;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="GoodsCategory")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="GoodsCategory", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="GoodsCategory", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="GoodsType", inversedBy="goodsCategory")
     * @ORM\JoinColumn(name="goods_type_id", referencedColumnName="id")
     */
    private $goodsType;

    /**
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=true,options={"comment":"排序"})
     */
    private $sort = '100';



    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setParent(GoodsCategory $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    public function getSort()
    {
        return $this->sort;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return GoodsCategory
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return GoodsCategory
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return GoodsCategory
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param \Hn\SwBundle\Entity\GoodsCategory $root
     *
     * @return GoodsCategory
     */
    public function setRoot(\Hn\SwBundle\Entity\GoodsCategory $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Add child
     *
     * @param \Hn\SwBundle\Entity\GoodsCategory $child
     *
     * @return GoodsCategory
     */
    public function addChild(\Hn\SwBundle\Entity\GoodsCategory $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Hn\SwBundle\Entity\GoodsCategory $child
     */
    public function removeChild(\Hn\SwBundle\Entity\GoodsCategory $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set goodsType
     *
     * @param \Hn\SwBundle\Entity\GoodsType $goodsType
     *
     * @return GoodsCategory
     */
    public function setGoodsType(\Hn\SwBundle\Entity\GoodsType $goodsType = null)
    {
        $this->goodsType = $goodsType;

        return $this;
    }

    /**
     * Get goodsType
     *
     * @return \Hn\SwBundle\Entity\GoodsType
     */
    public function getGoodsType()
    {
        return $this->goodsType;
    }
}
