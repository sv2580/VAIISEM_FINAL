<?php

namespace App\Models;

class Message extends \App\Core\Model
{

    public function __construct(
        public int $id = 0,
        public ?string $receiver ="",
        public ?string $sender ="",
        public ?string $message ="",
        public ?string $date_of_message = ""
    )
    {


    }

    /**
     * @return string|null
     */
    public function getDateOfMessage(): ?string
    {
        return $this->date_of_message;
    }

    /**
     * @param string|null $date_of_message
     */
    public function setDateOfMessage(?string $date_of_message): void
    {
        $this->date_of_message = $date_of_message;
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
    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    /**
     * @param string|null $receiver
     */
    public function setReceiver(?string $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return string|null
     */
    public function getSender(): ?string
    {
        return $this->sender;
    }

    /**
     * @param string|null $sender
     */
    public function setSender(?string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */


    static public function setDbColumns()
    {
        return ['id','receiver','sender','message','date_of_message'];
    }

    static public function setTableName()
    {
        return 'message';
    }
}