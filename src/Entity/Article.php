<?php
/**
 * Created by PhpStorm.
 * User: qaltamore
 * Date: 03/09/18
 * Time: 22:33
 */

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Article
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string",length=10000)
     */
    private $content;
    /**
     *@ORM\Column(type="datetime", nullable=true, name="posted_at")
     */
    private $date;

    /**
     *@ORM\Column(type="datetime", type="boolean", options={"default":false})
     */
    private $isPublished;

    /**
     * @return mixed
     */
    public function isPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    /**
     * @return \DateTime
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }
    /**
     * @param string $date
     */
    public function setDate($date): void
    {
        if(!$date){
            $this->date = null;
        }
        else {
            date_default_timezone_set("Europe/Paris");
            $this->date = new \DateTime('now');
        }
    }

}