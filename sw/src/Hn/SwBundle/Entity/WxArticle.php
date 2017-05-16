<?php

namespace Hn\SwBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxArticle
 *
 * @ORM\Table(name="wx_article")
 * @ORM\Entity
 */
class WxArticle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="media_id", type="string", length=255, nullable=true)
     */
    private $mediaId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="digest", type="string", length=255, nullable=true)
     */
    private $digest;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb_url", type="string", length=255, nullable=true)
     */
    private $thumb_url;

    /**
     * @var string
     *
     * @ORM\Column(name="content_source_url", type="string", length=255, nullable=true)
     */
    private $contentSourceUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="ar_update_time", type="string", length=255, nullable=true)
     */
    private $arUpdateTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_time", type="integer", nullable=true)
     */
    private $createTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="update_time", type="integer", nullable=true)
     */
    private $updateTime;



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
     * Set mediaId
     *
     * @param string $mediaId
     *
     * @return WxArticle
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     *
     * @return string
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return WxArticle
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return WxArticle
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set digest
     *
     * @param string $digest
     *
     * @return WxArticle
     */
    public function setDigest($digest)
    {
        $this->digest = $digest;

        return $this;
    }

    /**
     * Get digest
     *
     * @return string
     */
    public function getDigest()
    {
        return $this->digest;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return WxArticle
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return WxArticle
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set contentSourceUrl
     *
     * @param string $contentSourceUrl
     *
     * @return WxArticle
     */
    public function setContentSourceUrl($contentSourceUrl)
    {
        $this->contentSourceUrl = $contentSourceUrl;

        return $this;
    }

    /**
     * Get contentSourceUrl
     *
     * @return string
     */
    public function getContentSourceUrl()
    {
        return $this->contentSourceUrl;
    }

    /**
     * Set arUpdateTime
     *
     * @param string $arUpdateTime
     *
     * @return WxArticle
     */
    public function setArUpdateTime($arUpdateTime)
    {
        $this->arUpdateTime = $arUpdateTime;

        return $this;
    }

    /**
     * Get arUpdateTime
     *
     * @return string
     */
    public function getArUpdateTime()
    {
        return $this->arUpdateTime;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     *
     * @return WxArticle
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
     * @return WxArticle
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
     * Set thumbUrl
     *
     * @param string $thumbUrl
     *
     * @return WxArticle
     */
    public function setThumbUrl($thumbUrl)
    {
        $this->thumb_url = $thumbUrl;

        return $this;
    }

    /**
     * Get thumbUrl
     *
     * @return string
     */
    public function getThumbUrl()
    {
        return $this->thumb_url;
    }
}
