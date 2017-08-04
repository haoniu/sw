<?php

namespace Hn\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Hn\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
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
     * @var integer
     *
     * @ORM\Column(name="user_type", type="integer", nullable=false)
     */
    private $userType = '10';

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=50, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=30, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_degree", type="integer", nullable=true)
     */
    private $userDegree = '10';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_resouce", type="integer", nullable=true)
     */
    private $userResouce;

    /**
     * @var string
     *
     * @ORM\Column(name="user_sn", type="string", length=50, nullable=true)
     */
    private $userSn;

    /**
     * @var string
     *
     * @ORM\Column(name="user_desc", type="string", length=255, nullable=true)
     */
    private $userDesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    private $gender = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="birthday", type="integer", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="qq_no", type="string", length=50, nullable=true)
     */
    private $qqNo;

    /**
     * @var string
     *
     * @ORM\Column(name="weibo_no", type="string", length=50, nullable=true)
     */
    private $weiboNo;

    /**
     * @var string
     *
     * @ORM\Column(name="weixin_no", type="string", length=50, nullable=true)
     */
    private $weixinNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_auth", type="integer", nullable=true)
     */
    private $isAuth = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="realname", type="string", length=50, nullable=true)
     */
    private $realname;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_login_time", type="integer", nullable=true)
     */
    private $lastLoginTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="oper_id", type="integer", nullable=true)
     */
    private $operId;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_time", type="integer", nullable=false)
     */
    private $createTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="update_time", type="integer", nullable=false)
     */
    private $updateTime;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="text", nullable=true)
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    public function __construct()
    {
        $this->isActive = true;

        $this->salt = md5(uniqid(null, true));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }


    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
        $this->setCreateTime(time());
        $this->setUpdateTime(time());
    }

    /**
     * @ORM\PreUpdate
     */
    public function PreUpdate()
    {
        $this->setUpdateTime(time());
    }









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
     * Set userType
     *
     * @param integer $userType
     *
     * @return Users
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return integer
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Users
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Users
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Users
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Users
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set userDegree
     *
     * @param integer $userDegree
     *
     * @return Users
     */
    public function setUserDegree($userDegree)
    {
        $this->userDegree = $userDegree;

        return $this;
    }

    /**
     * Get userDegree
     *
     * @return integer
     */
    public function getUserDegree()
    {
        return $this->userDegree;
    }

    /**
     * Set userResouce
     *
     * @param integer $userResouce
     *
     * @return Users
     */
    public function setUserResouce($userResouce)
    {
        $this->userResouce = $userResouce;

        return $this;
    }

    /**
     * Get userResouce
     *
     * @return integer
     */
    public function getUserResouce()
    {
        return $this->userResouce;
    }

    /**
     * Set userSn
     *
     * @param string $userSn
     *
     * @return Users
     */
    public function setUserSn($userSn)
    {
        $this->userSn = $userSn;

        return $this;
    }

    /**
     * Get userSn
     *
     * @return string
     */
    public function getUserSn()
    {
        return $this->userSn;
    }

    /**
     * Set userDesc
     *
     * @param string $userDesc
     *
     * @return Users
     */
    public function setUserDesc($userDesc)
    {
        $this->userDesc = $userDesc;

        return $this;
    }

    /**
     * Get userDesc
     *
     * @return string
     */
    public function getUserDesc()
    {
        return $this->userDesc;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Users
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param integer $birthday
     *
     * @return Users
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return integer
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Users
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set qqNo
     *
     * @param string $qqNo
     *
     * @return Users
     */
    public function setQqNo($qqNo)
    {
        $this->qqNo = $qqNo;

        return $this;
    }

    /**
     * Get qqNo
     *
     * @return string
     */
    public function getQqNo()
    {
        return $this->qqNo;
    }

    /**
     * Set weiboNo
     *
     * @param string $weiboNo
     *
     * @return Users
     */
    public function setWeiboNo($weiboNo)
    {
        $this->weiboNo = $weiboNo;

        return $this;
    }

    /**
     * Get weiboNo
     *
     * @return string
     */
    public function getWeiboNo()
    {
        return $this->weiboNo;
    }

    /**
     * Set weixinNo
     *
     * @param string $weixinNo
     *
     * @return Users
     */
    public function setWeixinNo($weixinNo)
    {
        $this->weixinNo = $weixinNo;

        return $this;
    }

    /**
     * Get weixinNo
     *
     * @return string
     */
    public function getWeixinNo()
    {
        return $this->weixinNo;
    }

    /**
     * Set isAuth
     *
     * @param integer $isAuth
     *
     * @return Users
     */
    public function setIsAuth($isAuth)
    {
        $this->isAuth = $isAuth;

        return $this;
    }

    /**
     * Get isAuth
     *
     * @return integer
     */
    public function getIsAuth()
    {
        return $this->isAuth;
    }

    /**
     * Set realname
     *
     * @param string $realname
     *
     * @return Users
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set lastLoginTime
     *
     * @param integer $lastLoginTime
     *
     * @return Users
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;

        return $this;
    }

    /**
     * Get lastLoginTime
     *
     * @return integer
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Users
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
     * Set operId
     *
     * @param integer $operId
     *
     * @return Users
     */
    public function setOperId($operId)
    {
        $this->operId = $operId;

        return $this;
    }

    /**
     * Get operId
     *
     * @return integer
     */
    public function getOperId()
    {
        return $this->operId;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     *
     * @return Users
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
     * @return Users
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Users
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set roles
     *
     * @param string $roles
     *
     * @return Users
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Users
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
