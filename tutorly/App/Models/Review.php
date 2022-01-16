<?php

namespace App\Models;

class Review extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public ?string $receiver ="",
        public ?string $sender ="",
        public ?string $review ="",
        public ?string $dateof ="",
        public int $rating = 0,
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
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
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
    public function getReview(): ?string
    {
        return $this->review;
    }

    /**
     * @param string|null $review
     */
    public function setReview(?string $review): void
    {
        $this->review = $review;
    }

    static public function setDbColumns()
    {
        return ['id','receiver','sender','review','dateof','rating','reported'];
    }

    static public function setTableName()
    {
        return "review";
    }

    /**
     * @return string|null
     */
    public function getDateof(): ?string
    {
        return $this->dateof;
    }

    /**
     * @param string|null $dateof
     */
    public function setDateof(?string $dateof): void
    {
        $this->dateof = $dateof;
    }
}