<?php

namespace Game\Model;

/**
 * Class Player
 */
class Player
{
    /**
     * @var Pile
     */
    private Pile $pile;

    /**
     * @var string
     */
    private string $name;

    /**
     * Player constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->pile = new Pile();
    }

    /**
     * @param int $rank
     * @param int $color
     *
     * @return Card|null
     */
    public function drawSuitableCard(int $rank, int $color): ?Card
    {
        // Search through pile for suitable card.
        foreach ($this->pile->getCards() as $index => $card) {
            if ($card->getRank() === $rank || $card->getColor() === $color) {
                return $this->pile->drawCard($index);
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Pile
     */
    public function getPile(): Pile
    {
        return $this->pile;
    }
}
