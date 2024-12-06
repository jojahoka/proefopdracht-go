<?php

namespace Models;
require_once 'TotalResult.php';

class ResultCalculator
{

    /**
     * @param Vote[] $votes
     *
     * @return string
     */
    public function calculateResult(array $votes): string
    {
        $totalResult = new TotalResult();

        $in_favor = 0;
        $against = 0;
        foreach ($votes as $vote) {
            if($vote->isFor()){
                $in_favor++;
            }
            else {
                $against++;
            }
        }

        $totalResult->setIsAccepted($in_favor > $against);


        if ($totalResult->isAccepted()) {
            $result = "aangenomen";
        } else {
            $result = "afgewezen";
        }

        return $result;
    }

    /**
     * @param PartyResult[] $votes
     *
     * @return string
     */
    public function calculatePartiesResult(array $party_results): string
    {
        $totalResult = new TotalResult();

        $in_favor = 0;
        $against = 0;
        foreach ($party_results as $party_result) {
            $in_favor =+ $party_result->getAmountFor();
            $against =+ $party_result->getAmountAgainst();
        }
        $totalResult->setIsAccepted($in_favor > $against);
        $totalResult->setPartyResults($party_results);

        if ($totalResult->isAccepted()) {
            $result = "aangenomen";
        } else {
            $result = "afgewezen";
        }

        return $result;
    }


}