<?php

namespace App\Models;

use App\Core\Model;

class Login extends \App\Core\Model
{
    public function __construct(
        public int $birthyear = 0,
        public ?string $password = "",
        public ?string $email = "",
        public ?string $name = "",
        public ?string $surname = "",
        public int $id = 0,
        public int $admin = 0,
        public ?string $profilepic = "",
        public int $reports = 0
    )
    {

    }

    /**
     * @return int
     */
    public function getReports(): int
    {
        return $this->reports;
    }

    /**
     * @param int $reports
     */
    public function setReports(int $reports): void
    {
        $this->reports = $reports;
    }

    /**
     * @return string|null
     */
    public function getProfilepic(): ?string
    {
        return $this->profilepic;
    }

    /**
     * @param string|null $profilepic
     */
    public function setProfilepic(?string $profilepic): void
    {
        $this->profilepic = $profilepic;
    }

    /**
     * @return int
     */
    public function getAdmin(): int
    {
        return $this->admin;
    }

    /**
     * @param int $admin
     */
    public function setAdmin(int $admin): void
    {
        $this->admin = $admin;
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
     * @return int
     */
    public function getBirthyear(): int
    {
        return $this->birthyear;
    }

    /**
     * @param int $birthyear
     */
    public function setBirthyear(int $birthyear): void
    {
        $this->birthyear = $birthyear;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    static public function setDbColumns()
    {
        return ['email','password','name','surname','birthyear','id','admin','profilepic','reports'];
    }

    static public function setTableName()
    {
        return 'login';
    }
}