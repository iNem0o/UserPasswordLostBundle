<?php

namespace inem0o\UserPasswordLostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;

/**
 * PasswordResetRequest
 *
 * @ORM\Table(name="password_reset_request_identity")
 * @ORM\Entity(repositoryClass="inem0o\UserPasswordLostBundle\Repository\PasswordResetRequestIdentityRepository")
 */
class PasswordResetRequestIdentity
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
     * @ORM\ManyToOne(targetEntity="inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest", inversedBy="identities")
     */
    private $password_reset_request;

    /**
     * @var int
     *
     * @ORM\Column(name="ip_address", type="binary",length=16)
     */
    private $ip_address;

    /**
     * @var int
     *
     * @ORM\Column(name="ip_address_source_port", type="integer")
     */
    private $ip_address_source_port;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $request_status = 0;

    public static function factoryFromRequest(Request $request)
    {
        $identity = new PasswordResetRequestIdentity();
        $identity->setIpAddress($request->getClientIp());
        $identity->setIpAddressSourcePort($request->server->get('REMOTE_PORT'));

        return $identity;
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
     * Set passwordResetRequest
     *
     * @param \inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest $passwordResetRequest
     *
     * @return PasswordResetRequestIdentity
     */
    public function setPasswordResetRequest(\inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest $passwordResetRequest = null)
    {
        $this->password_reset_request = $passwordResetRequest;

        return $this;
    }

    /**
     * Get passwordResetRequest
     *
     * @return \inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest
     */
    public function getPasswordResetRequest()
    {
        return $this->password_reset_request;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return PasswordResetRequestIdentity
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = inet_pton($ipAddress);

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return binary
     */
    public function getIpAddress()
    {
        return inet_ntop($this->ip_address);
    }

    /**
     * Set ipAddressSourcePort
     *
     * @param integer $ipAddressSourcePort
     *
     * @return PasswordResetRequestIdentity
     */
    public function setIpAddressSourcePort($ipAddressSourcePort)
    {
        $this->ip_address_source_port = $ipAddressSourcePort;

        return $this;
    }

    /**
     * Get ipAddressSourcePort
     *
     * @return integer
     */
    public function getIpAddressSourcePort()
    {
        return $this->ip_address_source_port;
    }

    /**
     * Set requestStatus
     *
     * @param integer $requestStatus
     *
     * @return PasswordResetRequestIdentity
     */
    public function setRequestStatus($requestStatus)
    {
        $this->request_status = $requestStatus;

        return $this;
    }

    /**
     * Get requestStatus
     *
     * @return integer
     */
    public function getRequestStatus()
    {
        return $this->request_status;
    }
}
