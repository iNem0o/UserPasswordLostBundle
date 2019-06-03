<?php

namespace inem0o\UserPasswordLostBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PasswordResetRequest
 * @ORM\Table(name="password_reset_request")
 * @ORM\Entity(repositoryClass="inem0o\UserPasswordLostBundle\Repository\PasswordResetRequestRepository")
 */
class PasswordResetRequest
{
    const STATUS_PENDING = 0;
    const STATUS_USED = 1;
    const STATUS_EXPIRED = 2;

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=191, unique=true)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(name="user_email", type="string", length=255)
     */
    private $user_email;

    /**
     * @var string
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $date_add;

    /**
     * @var string
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $date_end;

    /**
     * @var string
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;

    /**
     * @var PasswordResetRequestIdentity[]
     * @ORM\OneToMany(targetEntity="inem0o\UserPasswordLostBundle\Entity\PasswordResetRequestIdentity", mappedBy="password_reset_request", orphanRemoval=true)
     */
    private $identities;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return PasswordResetRequest
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return PasswordResetRequest
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return PasswordResetRequest
     */
    public function setDateAdd($dateAdd)
    {
        $this->date_add = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->date_add;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return PasswordResetRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return PasswordResetRequest
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identities = new ArrayCollection();
    }

    /**
     * Add identity
     *
     * @param \inem0o\UserPasswordLostBundle\Entity\PasswordResetRequestIdentity $identity
     *
     * @return PasswordResetRequest
     */
    public function addIdentity(\inem0o\UserPasswordLostBundle\Entity\PasswordResetRequestIdentity $identity)
    {
        $this->identities[] = $identity;

        return $this;
    }

    /**
     * Remove identity
     *
     * @param \inem0o\UserPasswordLostBundle\Entity\PasswordResetRequestIdentity $identity
     */
    public function removeIdentity(\inem0o\UserPasswordLostBundle\Entity\PasswordResetRequestIdentity $identity)
    {
        $this->identities->removeElement($identity);
    }

    /**
     * Get identities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdentities()
    {
        return $this->identities;
    }
}
