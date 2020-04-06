<?php

namespace Game\Model;

/**
 * Class Deck
 */
class Pile
{
    /**
     * @var Card[]
     */
    private array $cards;

    /**
     * Pile constructor.
     */
    public function __construct()
    {
        $this->cards = [];
    }

    /**
     * @param Card $card
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * @param Card[] $cards
     */
    public function addCards(array $cards): void
    {
        shuffle($cards);

        $this->cards = array_merge($cards, $this->cards);
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @param int $index
     *
     * @return Card
     */
    public function drawCard(int $index): Card
    {
        $card = $this->cards[$index];

        unset($this->cards[$index]);

        return $card;
    }

    /**
     * @return Card
     */
    public function drawTopCard(): Card
    {
        return array_pop($this->cards);
    }

    /**
     * @return Card
     */
    public function getTopCard(): Card
    {
        return end($this->cards);
    }

    /**
     * Draws all but the top card.
     *
     * @return array
     */
    public function drawBottomCards(): array
    {
        $cards = array_slice($this->cards, 0, -1);
        $this->cards = [end($this->cards)];

        return $cards;
    }

    /**
     * @return bool
     */
    public function hasCards(): bool
    {
        return !empty($this->cards);
    }
}
