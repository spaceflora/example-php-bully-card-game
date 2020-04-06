<?php declare(strict_types=1);

namespace Game\Tests\Model;

use Game\Model\Card;
use Game\Model\Pile;
use PHPUnit\Framework\TestCase;

/**
 * Class PileTest
 */
class PileTest extends TestCase
{
    /**
     * Test adding one card.
     *
     * @return void
     */
    public function testAddCard(): void
    {
        $pile =$this->getEmptyMock();
        $pile->addCard(new Card(Card::RANK_2, Card::SUIT_CLUBS));

        $this->assertTrue($pile->hasCards());
        $this->assertCount(1, $pile->getCards());
    }

    /**
     * Test emptying a pile.
     *
     * @return void
     */
    public function testEmptyPile(): void
    {
        $pile = $this->getFilledMock();
        $pile->drawBottomCards();

        $this->assertTrue($pile->hasCards());

        $pile->drawTopCard();

        $this->assertFalse($pile->hasCards());
    }

    /**
     * @return Pile
     */
    private function getEmptyMock(): Pile
    {
        return new Pile();
    }

    /**
     * @return Pile
     */
    private function getFilledMock(): Pile
    {
        $pile = new Pile();
        $pile->addCards([
            new Card(Card::RANK_2, Card::SUIT_CLUBS),
            new Card(Card::RANK_3, Card::SUIT_CLUBS),
            new Card(Card::RANK_4, Card::SUIT_CLUBS),
        ]);

        return $pile;
    }
}
