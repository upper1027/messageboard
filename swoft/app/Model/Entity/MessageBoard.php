<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * Class MessageBoard
 *
 * @since 2.0
 *
 * @Entity(table="message_board")
 */
class MessageBoard extends Model
{
    /**
     * @Id()
     *
     * @Column(name="id")
     */
    private $id;

    /**
     * @Column(name="user_id")
     */
    private $userId;

    /**
     * @Column(name="user_name")
     */
    private $userName;

    /**
     * @Column(name="content")
     */
    private $content;

    /**
     * @Column(name="add_time")
     */
    private $addTime;


    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     *
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getAddTime(): ?string
    {
        return $this->addTime;
    }

    /**
     * @param string
     */
    public function setAddTime(?string $addTime): void
    {
        $this->addTime= $addTime;
    }

    /**
     * @return string|null
     */

}