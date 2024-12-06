<?php

namespace Models;
class PartyResult
{
    /**
     * @var string
     */
    private $partyName;

    /**
     * @var integer
     */
    private $amountFor = 0;

    /**
     * @var integer
     */
    private $amountAgainst = 0;

    /**
     * @var array
     */
    private $votes;


    function __construct($partyName, $votes = []){
        $this->partyName = $partyName;
        $this->setVotes($votes);
    }

    /**
     * @return string
     */
    public function getPartyName(): string
    {
        return $this->partyName;
    }

    /**
     * @param string $partyName
     */
    public function setPartyName(string $partyName): void
    {
        $this->partyName = $partyName;
    }

    /**
     * @return int
     */
    public function getAmountFor(): int
    {
        return $this->amountFor;
    }

    /**
     * @param int $amountFor
     */
    private function setAmountFor(int $amountFor): void
    {
        $this->amountFor = $amountFor;
    }

    /**
     * @return int
     */
    public function getAmountAgainst(): int
    {
        return $this->amountAgainst;
    }

    /**
     * @param int $amountAgainst
     */
    private function setAmountAgainst(int $amountAgainst): void
    {
        $this->amountAgainst = $amountAgainst;
    }

    public function setVotes(array $votes): void
    {
        $in_favor = 0;
        $against = 0;
        foreach ($votes as $vote) {
            $vote->isfor() ? $in_favor++ : $against++;
        }
        $this->setAmountAgainst($against);
        $this->setAmountFor($in_favor);
        $this->votes = $votes;
    }

    public function getVotes(): array
    {
        return $this->votes;
    }

}