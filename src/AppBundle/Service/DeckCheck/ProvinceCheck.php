<?php

namespace AppBundle\Service\DeckCheck;

use AppBundle\Entity\Card;
use AppBundle\Model\CardSlotCollectionDecorator;
use AppBundle\Service\DeckValidator;

/**
 * Description of ProvinceChecker
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ProvinceCheck implements DeckCheckInterface
{
    public function check(CardSlotCollectionDecorator $deckCards): int
    {
        $provinceSlots = $deckCards->filterByType(Card::TYPE_PROVINCE);

        if($provinceSlots->countCards() < 5) {
            return DeckValidator::TOO_FEW_PROVINCE;
        }

        if($provinceSlots->countCards() > 5) {
            return DeckValidator::TOO_MANY_PROVINCE;
        }

        $provinceElements = array_unique(
            array_map(
                function ($slot) {
                    return $slot->getCard()->getElement();
                },
                $provinceSlots->toArray()
            )
        );
        if(count($provinceElements) < 5) {
            return DeckValidator::DUPLICATE_ELEMENT;
        }

        $strongholdSlot = $deckCards->findStrongholdSlot();
        if ($strongholdSlot !== null) {
            $stronghold = $strongholdSlot->getCard();
            $clan = $stronghold->getClan();

            $offClanProvinceSlot = $provinceSlots->find(function ($slot) use ($clan) {
                /** @var CardSlotInterface $slot */
                return $slot->getCard()->getClan() !== 'neutral'
                    && $slot->getCard()->getClan() !== $clan;
            });

            if($offClanProvinceSlot !== null) {
                return DeckValidator::OFF_CLAN_PROVINCE;
            }
        }

        return DeckValidator::VALID_DECK;
    }
}