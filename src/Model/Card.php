<?php

namespace Game\Model;

/**
 * Class Card
 */
class Card
{
    const COLOR_BLACK = 1;
    const COLOR_RED = 2;
    const RANK_2 = 1;
    const RANK_3 = 2;
    const RANK_4 = 3;
    const RANK_5 = 4;
    const RANK_6 = 5;
    const RANK_7 = 6;
    const RANK_8 = 7;
    const RANK_9 = 8;
    const RANK_10 = 9;
    const RANK_JACK = 10;
    const RANK_QUEEN = 11;
    const RANK_KING = 12;
    const RANK_ACE = 13;
    const SUIT_CLUBS = 1;
    const SUIT_DIAMONDS = 2;
    const SUIT_HEARTS = 3;
    const SUIT_SPADES = 4;

    /**
     * @var int
     */
    private int $rank;

    /**
     * @var int
     */
    private int $suit;

    /**
     * @var int
     */
    private int $color;

    /**
     * Card constructor.
     *
     * @param int $rank
     * @param int $suit
     */
    public function __construct(int $rank, int $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;

        // Set color by suit.
        if (in_array($this->suit, [self::SUIT_CLUBS, self::SUIT_SPADES])) {
            $this->color = self::COLOR_BLACK;
        } else {
            $this->color = self::COLOR_RED;
        }
    }

    /**
     * @return array
     */
    public static function getRanks(): array
    {
        return [
            self::RANK_2,
            self::RANK_3,
            self::RANK_4,
            self::RANK_5,
            self::RANK_6,
            self::RANK_7,
            self::RANK_8,
            self::RANK_9,
            self::RANK_10,
            self::RANK_JACK,
            self::RANK_QUEEN,
            self::RANK_KING,
            self::RANK_ACE,
        ];
    }

    /**
     * @return array
     */
    public static function getSuits(): array
    {
        return [
            self::SUIT_CLUBS,
            self::SUIT_DIAMONDS,
            self::SUIT_HEARTS,
            self::SUIT_SPADES,
        ];
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @return int
     */
    public function getSuit(): int
    {
        return $this->suit;
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }
}
