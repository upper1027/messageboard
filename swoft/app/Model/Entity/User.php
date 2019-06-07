<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * Class User
 *
 * @since 2.0
 *
 * @Entity(table="user")
 */
class User extends Model
{
    /**
     * @Id()
     *
     * @Column(name="id")
     *
     */
    private $id;

    /**
     * @Column(name="user_name")
     *
     */
    private $userName;

    /**
     * @Column(name="password")
     *
     */
    private $pwd;

    /**
     * @Column(name="add_time")
     *
     */
    private $addTime;

    /**
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     *
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     *
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }


    /**
     *
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     *
     */
    public function setPwd(string $pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     *
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * 
     */
    public function setAddTime(string $addTime)
    {
        $this->addTime = $addTime;
    }
}