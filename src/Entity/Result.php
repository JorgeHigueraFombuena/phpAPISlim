<?php   // src/Entity/Result.php

namespace MiW16\Results\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Result
 *
 * @package MiW16\Results\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *      name="results",
 *      indexes={
 *          @ORM\Index(name="FK_USER_ID_idx", columns={"user_id"})
 *      }
 *     )
 */
class Result implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="result", type="integer", nullable=false)
     */
    protected $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=false)
     */
    protected $time;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * Result constructor.
     *
     * @param int       $result result
     * @param User      $user   user
     * @param \DateTime $time   time
     */
    public function __construct(int $result, User $user, \DateTime $time)
    {
        $this->id     = 0;
        $this->result = $result;
        $this->user   = $user;
        $this->time   = $time;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getResult(): int
    {
        return $this->result;
    }

    /**
     * @param int $result
     * @return Result
     */
    public function setResult(int $result): Result
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Result
     */
    public function setUser(User $user): Result
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     * @return Result
     */
    public function setTime(\DateTime $time): Result
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Implements __toString()
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString(): string
    {
        return sprintf(
            '%3d - %3d - %30s - %s',
            $this->id,
            $this->result,
            $this->user,
            $this->time->format('Y-m-d H:i:s')
        );
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return array(
            'id'     => $this->id,
            'result' => $this->result,
            'user'   => $this->user,
            'time'   => $this->time
        );
    }
}

/**
 * @SWG\Definition(
 *     definition="Result",
 *     required = { "id", "result", "user", "time" },
 *     @SWG\Property(
 *          property    = "id",
 *          description = "Result Id",
 *          type        = "integer",
 *          format      = "int32"
 *      ),
 *      @SWG\Property(
 *          property    = "result",
 *          description = "Result value",
 *          type        = "integer",
 *          format      = "int32"
 *      ),
 *      @SWG\Property(
 *          property    = "user",
 *          description = "User data",
 *          type        = "User"
 *      ),
 *      @SWG\Property(
 *          property    = "time",
 *          description = "Date of result",
 *          type        = "date"
 *      ),
 *      example = {
 *          "id"        = 1508,
 *          "result"    = 10,
 *          "user"      = user {
 *                          "username"  = "User_name",
 *                          "email"     = "User_email@example.com",
 *                          "password"  = "User_password",
 *                          "enabled"   = true,
 *                          "token"     = "$2$6a7f5b9e15f9c4a51495"
 *                        },
 *          "time"   = {
 *                      "date": "1992-10-14 20:52:56.000000",
 *                      "timezone_type": 3,
 *                      "timezone": "Europe/Madrid"
 *                     }
 *     }
 * )
 * @SWG\Parameter(
 *      name        = "resultId",
 *      in          = "path",
 *      description = "ID of result to fetch",
 *      required    = true,
 *      type        = "integer",
 *      format      = "int32"
 * )
 */

/**
 * @SWG\Property(
 *          property    = "id",
 *          description = "Result Id",
 *          type        = "integer",
 *          format      = "int32"
 *      ),
 *      @SWG\Property(
 *          property    = "result",
 *          description = "Result value",
 *          type        = "integer",
 *          format      = "int32"
 *      ),
 *      @SWG\Property(
 *          property    = "user",
 *          description = "User data",
 *          type        = "User"
 *      ),
 *      @SWG\Property(
 *          property    = "time",
 *          description = "Date of result",
 *          type        = "date"
 *      ),
 *      example = {
 *          "id"        = 1508,
 *          "result"    = 10,
 *          "user"      = user {
 *                          "username"  = "User_name",
 *                          "email"     = "User_email@example.com",
 *                          "password"  = "User_password",
 *                          "enabled"   = true,
 *                          "token"     = "$2$6a7f5b9e15f9c4a51495"
 *                        },
 *          "time"   = {
 *                      "date": "1992-10-14 20:52:56.000000",
 *                      "timezone_type": 3,
 *                      "timezone": "Europe/Madrid"
 *                     }
 *     }
 * )
 */

/**
 * User array definition
 *
 * @SWG\Definition(
 *     definition = "ResultsArray",
 *      @SWG\Property(
 *          property    = "results",
 *          description = "Results array",
 *          type        = "array",
 *          items       = {
 *              "$ref": "#/definitions/Result"
 *          }
 *      )
 * )
 */