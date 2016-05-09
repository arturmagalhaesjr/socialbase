<?php

namespace SocialBase\RestBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 *
 * Esta Classe faz parte do sistema cms.web
 * (c)  Artur Magalhães <nezkal@gmail.com>
 * Para maiores informações visite o site www.tritoq.com
 *
 * @author Artur Magalhães <nezkal@gmail.com>
 *
 * @Entity()
 * @Table(name="social_messages")
 */
class Messages
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $datetime;

    /**
     * @var string
     * @Column(type="string")
     * @Length(max="140", min="1")
     * @NotNull()
     */
    protected $message;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     * @Exclude()
     */
    protected $ip;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     *
     * @return $this
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
}