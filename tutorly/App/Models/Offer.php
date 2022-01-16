<?php
namespace App\Models;

use App\Core\Model;

class Offer extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public ?string $title = "",
        public ?string $info = "",
        public ?string $place = "",
        public ?string $contact = "",
        public ?string $loginfk = "",
        public ?string $moreinfo = "",
        public ?string $education = "",
        public ?string $pay = "",
        public ?string $courses = "",
        public int $tutor = 0,
        public int $reported = 0
    )
    {

    }

    /**
     * @return int
     */
    public function getReported(): int
    {
        return $this->reported;
    }

    /**
     * @param int $reported
     */
    public function setReported(int $reported): void
    {
        $this->reported = $reported;
    }

    /**
     * @return int
     */
    public function getTutor(): int
    {
        return $this->tutor;
    }

    /**
     * @param int $tutor
     */
    public function setTutor(int $tutor): void
    {
        $this->tutor = $tutor;
    }



    /**
     * @return string|null
     */
    public function getMoreinfo(): ?string
    {
        return $this->moreinfo;
    }

    /**
     * @param string|null $moreinfo
     */
    public function setMoreinfo(?string $moreinfo): void
    {
        $this->moreinfo = $moreinfo;
    }

    /**
     * @return string|null
     */
    public function getEducation(): ?string
    {
        return $this->education;
    }

    /**
     * @param string|null $education
     */
    public function setEducation(?string $education): void
    {
        $this->education = $education;
    }

    /**
     * @return string|null
     */
    public function getPay(): ?string
    {
        return $this->pay;
    }

    /**
     * @param string|null $pay
     */
    public function setPay(?string $pay): void
    {
        $this->pay = $pay;
    }

    /**
     * @return string|null
     */
    public function getCourses(): ?string
    {
        return $this->courses;
    }

    /**
     * @param string|null $courses
     */
    public function setCourses(?string $courses): void
    {
        $this->courses = $courses;
    }

    /**
     * @return string|null
     */
    public function getLoginfk(): ?string
    {
        return $this->loginfk;
    }

    /**
     * @param string|null $loginfk
     */
    public function setLoginfk(?string $loginfk): void
    {
        $this->loginfk = $loginfk;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param string|null $info
     */
    public function setInfo(?string $info): void
    {
        $this->info = $info;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string|null $place
     */
    public function setPlace(?string $place): void
    {
        $this->place = $place;
    }

    /**
     * @return string|null
     */
    public function getContact(): ?string
    {
        return $this->contact;
    }

    /**
     * @param string|null $contact
     */
    public function setContact(?string $contact): void
    {
        $this->contact = $contact;
    }



    static public function setDbColumns()
    {
        return ['id','title','info','place','contact','loginfk','moreinfo','education','pay','courses','tutor','reported'];
    }

    static public function setTableName()
    {
        return "offers";
    }
}