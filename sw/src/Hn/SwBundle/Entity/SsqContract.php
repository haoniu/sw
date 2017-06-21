<?php

namespace Hn\SwBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SsqContract
 *
 * @ORM\Table(name="ssq_contract")
 * @ORM\Entity
 */
class SsqContract
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name = '姓名';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password = '证书密码';

    /**
     * @var string
     *
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     */
    private $identity = '证件号码';

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    private $province = '省';

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city = '市';

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address = '详细地址';

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255, nullable=false)
     */
    private $mobile = '手机号';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email = '邮箱';

    /**
     * @var string
     *
     * @ORM\Column(name="signid", type="string", length=255, nullable=true)
     */
    private $signid;

    /**
     * @var string
     *
     * @ORM\Column(name="docid", type="string", length=255, nullable=true)
     */
    private $docid;

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer", nullable=true)
     */
    private $uid;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=true)
     */
    private $status = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="contract_type", type="string", length=255, nullable=true)
     */
    private $contractType;


}

