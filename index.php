<?php

use Models\PartyResult;
use Models\ResultCalculator;
use Models\Vote;

require_once 'Vote.php';
require_once 'ResultCalculator.php';
require_once 'PartyResult.php';

$vote = new Vote();

function Opdracht1(){
    $in_favor = 0;
    $against = 0;
    $undecided = 0;
    for ($x = 1; $x <= 20000; $x++) {
        if($x % 4 == 0){
            if($x % 7 == 0){
                $undecided++;
            }
            else {
                $in_favor++;
            }
        }
        elseif($x % 7 == 0){
            $against++;
        }
    }

    echo "The number in favor is: $in_favor <br>";
    echo "The number against is: $against <br>";
    echo "The number undecided is: $undecided <br>";
}


function calculateOutcome(int $number): string
{
    $can_divide_by_4 = $number % 4 == 0;
    $can_divide_by_7 = $number % 7 == 0;

    if ($can_divide_by_4) {
        if($can_divide_by_7){
            return 'undecided';
        }
        else {
            return 'in_favor';
        }
    }
    if ($can_divide_by_7) {
        return 'against';
    }
    return 'no_vote';
}

function Opdracht2(int $total_letters_sent, int $total_votes_received, int $in_favor_voters, int $against_voters, int $undecided_voters, int $to_be_voted_amount, bool $initial_call){
    $total_letters_sent = $total_letters_sent + $to_be_voted_amount;
    $uncounted_voters = 0;

    $current_in_favor_voters = 0;
    $current_against_voters = 0;
    $current_undecided_voters = 0;

    for ($x = 1; $x <= $to_be_voted_amount; $x++) {
        $vote_result = calculateOutcome($x);

        switch($vote_result) {
            case 'undecided':
                $current_undecided_voters++;
                break;
            case 'in_favor':
                $current_in_favor_voters++;
                break;
            case 'against':
                $current_against_voters++;
                break;
            default:
                $uncounted_voters++;
                break;
        }
    }

    $votes_received = $current_against_voters + $current_in_favor_voters + $current_undecided_voters;
    $total_votes_received = $total_votes_received + $votes_received;

    $extra_votes = $initial_call ? $uncounted_voters : floor($votes_received / 10);

    $total_against_votes = $current_against_voters + $against_voters;
    $total_in_favor_votes = $current_in_favor_voters + $in_favor_voters;
    $total_undecided_votes = $current_undecided_voters + $undecided_voters;

    if($extra_votes > 0) {
        Opdracht2($total_letters_sent, $total_votes_received, $total_in_favor_votes, $total_against_votes, $total_undecided_votes, $extra_votes, false);
    }
    else {
        echo "Total against votes: $total_against_votes<br>";
        echo "Total in favor votes: $total_in_favor_votes<br>";
        echo "Total undecided votes: $total_undecided_votes<br>";
        echo "Total votes arrived: $total_votes_received<br>";
        echo "Total letters sent: $total_letters_sent<br>";

    }
}



function Opdracht3(){
    $votes = [];
    for ($x = 1; $x <= 200; $x++) {
        $vote = new Vote();
        $vote->setIsFor(rand(0,1) == 1);
        $votes[] = $vote;
    }
    $resultCalculator = new ResultCalculator();
    $result = $resultCalculator->calculateResult($votes);

    echo "Deze motie is ".$result;
}

# OPDRACHT 4 - VERBETERINGEN
# Ik heb te snel gelezen en verbeteringen geschreven in ResultCalculator en PartyResult. Alsnog zijn er veel andere verbeteringen mogelijk.
# Zo zou ik voor elk Model in ieder geval een constructor aanmaken zodat je niet apart methodes hoeft aan te roepen om iets te initialiseren.
# Daarnaast zou ik een partij model aanmaken die kan worden meegegeven aan PartyResult.
# Als er een partij model wordt gemaakt kunnen we ook gemakkelijk fractieleden van de partij aanpassen en kan er daarnaast makkelijk overheen geloopt worden.
# In vote model is er de ruimte om een persoonsnaam toe te voegen. Hierbij ga ik er van uit dat we dus een vote in een andere situtatie direct koppelen aan een persoon
# Ook hiervoor geldt dat er een persoon model aangemaakt zou kunnen worden die dan zowel in array vorm bij partij gebruikt zou kunnen worden evenals als referentie bij vote model
# Reden dat ik fan ben van het gebruik van vele models is om consistentie te bewaren. Er kan op deze manier gemakkelijk teruggeredeneert worden als er iets fout gaat en zorgt voor consistentie.
# Daarnaast zorgt het er ook voor dat het relatief gemakkelijk uit te breiden is, mocht dat in de toekomst nodig zijn.
# ResultCalculator en TotalResult zijn modellen die ik niet helemaal snap. Deze zouden gereduceert kunnen worden naar 1 model waaraan wij PartijResults kunnen meegeven
# waarop een calculatie kan worden gedaan. (Eigenlijk wat ik nu half heb gedaan in PartyResult).
#
# In algemene zin vond ik de technische assessment grappig om te doen. Wel merk ik dat mijn PHP skills wel wat opgefrist moeten worden aangezien puur PHP voor mij wel een tijdje geleden is.

function Opdracht4(){
    $parties = ['Partij voor de Burger', 'Landgenoten', 'Burgers in Beweging', 'Groenland', 'Radicaal Burgerland'];
    $partiesResults = [];
    foreach ($parties as $party) {
        $party_votes = [];
        for ($x = 1; $x <= rand(20, 50); $x++) {
            $vote = new Vote();
            $vote->setIsFor(rand(0,1) == 1);
            $party_votes[] = $vote;
        }

        $partyResult = new PartyResult($party, $party_votes);
        $partiesResults[] = $partyResult;
    }

    $resultCalculator = new ResultCalculator();
    $result = $resultCalculator->calculatePartiesResult($partiesResults);
    echo "Deze motie is ".$result;
}

//Opdracht1();
//Opdracht2(0, 0, 0, 0, 0, 20000, true);
//Opdracht3();
Opdracht4();