<?php

namespace Game;

use Game\Model\Card;
use Game\Model\Pile;
use Game\Model\Player;

/**
 * This class contains the methods to
 * - set up the game (deal)
 * - play the game (play)
 * - reset the game (reset)
 *
 * We have two piles and players with each an own pile of cards.
 * The cards are first put on the stock pile and shuffled.
 * Then one card is put on the table pile and a number of cards are given to each player.
 * The players then draw a suitable card each turn or draw one from the stock pile.
 * This is repeated until a player is out of cards, that player wins.
 *
 * Class Game
 */
class Game
{
    const ACTION_STARTING = 1;
    const ACTION_DEALT = 2;
    const ACTION_TOP_CARD = 4;
    const ACTION_PLAYS = 5;
    const ACTION_NOT_SUITABLE = 6;
    const ACTION_WON = 3;

    /**
     * This is where cards will be drawn from.
     *
     * @var Pile
     */
    private Pile $stockPile;

    /**
     * Pile of played cards.
     *
     * @var Pile
     */
    private Pile $tablePile;

    /**
     * @var Player[]
     */
    private array $players;

    /**
     * @var bool
     */
    private bool $isWeb;

    /**
     * Game constructor.
     *
     * @param bool $isWeb
     */
    public function __construct(bool $isWeb = false)
    {
        $this->isWeb = $isWeb;

        $this->reset();
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->stockPile = new Pile();
        $this->tablePile = new Pile();
        $this->players = [];

        // Build up deck of cards and set up stock pile.
        $cards = [];

        foreach (Card::getSuits() as $cardSuit) {
            foreach (Card::getRanks() as $cardRank) {
                $cards[] = new Card($cardRank, $cardSuit);
            }
        }

        $this->stockPile->addCards($cards);
    }

    /**
     * @param array $playerNames
     * @param int $cardNumber
     */
    public function deal(array $playerNames, int $cardNumber = 7): void
    {
        $this->printAction(self::ACTION_STARTING, null, null, $playerNames);

        // Set up players.
        foreach ($playerNames as $playerName) {
            $player = new Player($playerName);

            // Set up player's cards.
            for ($i = 0; $i < $cardNumber; ++$i) {
                $topCard = $this->stockPile->drawTopCard();
                $player->getPile()->addCard($topCard);
            }

            $this->players[] = $player;

            $this->printAction(self::ACTION_DEALT, $player);
        }

        // Set up table pile.
        $topCard = $this->stockPile->drawTopCard();
        $this->tablePile->addCard($topCard);

        $this->printAction(self::ACTION_TOP_CARD, null, $topCard);
    }

    /**
     * @param int $action
     * @param null|Player $player
     * @param null|Card $card
     * @param array $array
     */
    private function printAction(int $action, ?Player $player, ?Card $card = null, array $array = []): void
    {
        if (self::ACTION_STARTING === $action) {
            printf('Starting game with %s', implode(', ', $array));
        } elseif (self::ACTION_DEALT === $action) {
            $cards = [];

            foreach ($player->getPile()->getCards() as $card) {
                $cards[] = sprintf('%s', $this->printCard($card));
            }

            printf('%s has been dealt: %s', $player->getName(), implode(' ', $cards));
        } elseif (self::ACTION_TOP_CARD === $action) {
            printf('Top card is: %s', $this->printCard($card));
        } elseif (self::ACTION_PLAYS === $action) {
            printf('%s plays %s', $player->getName(), $this->printCard($card));
        } elseif (self::ACTION_NOT_SUITABLE === $action) {
            printf('%s does not have a suitable card, taking from deck %s', $player->getName(), $this->printCard($card));
        } elseif (self::ACTION_WON === $action) {
            printf('%s has won.', $player->getName());
        }

        printf(true === $this->isWeb ? '<br />' : "\n");
    }

    /**
     * @param Card $card
     *
     * @return string
     */
    private function printCard(Card $card): string
    {
        $suit = [
            Card::SUIT_CLUBS => "\xE2\x99\xA3",
            Card::SUIT_DIAMONDS => "\xE2\x99\xA6",
            Card::SUIT_HEARTS => "\xE2\x99\xA5",
            Card::SUIT_SPADES => "\xE2\x99\xA0",
        ][$card->getSuit()];

        $rank = [
            Card::RANK_2 => "2",
            Card::RANK_3 => "3",
            Card::RANK_4 => "4",
            Card::RANK_5 => "5",
            Card::RANK_6 => "6",
            Card::RANK_7 => "7",
            Card::RANK_8 => "8",
            Card::RANK_9 => "9",
            Card::RANK_10 => "10",
            Card::RANK_JACK => "Jack",
            Card::RANK_QUEEN => "Queen",
            Card::RANK_KING => "King",
            Card::RANK_ACE => "Ace",
        ][$card->getRank()];

        if (true === $this->isWeb) {
            return sprintf('<span class="card-color-%d">%s%s</span>', $card->getColor(), $suit, $rank);
        }

        return $suit . $rank;
    }

    /**
     * @return void
     */
    public function play(): void
    {
        $i = 0;
        $playerCount = count($this->players);

        // Play while players have cards.
        do {
            $topCard = $this->tablePile->getTopCard();

            // Get player and draw a suitable card.
            $player = $this->players[($i % $playerCount)];
            $card = $player->drawSuitableCard($topCard->getRank(), $topCard->getColor());

            // Check if player has suitable card.
            if (null === $card) {
                // Check if stock pile should be re-filled.
                if (false === $this->stockPile->hasCards()) {
                    $cards = $this->tablePile->drawBottomCards();
                    $this->stockPile->addCards($cards);
                }

                // Add new card to player.
                $drawnCard = $this->stockPile->drawTopCard();
                $player->getPile()->addCard($drawnCard);

                $this->printAction(self::ACTION_NOT_SUITABLE, $player, $drawnCard);
            } else {
                $this->tablePile->addCard($card);

                $this->printAction(self::ACTION_PLAYS, $player, $card);
            }

            ++$i;
        } while ($player->getPile()->hasCards());

        $this->printAction(self::ACTION_WON, $player);
    }
}
