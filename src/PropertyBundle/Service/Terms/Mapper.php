<?php
declare(strict_types = 1);

namespace PropertyBundle\Service\Terms;

use PropertyBundle\Entity\Terms;

/**
 * Class Mapper
 * @package PropertyBundle\Service\Type
 */
class Mapper
{
    /**
     * @param string $language
     * @param Terms  $term
     *
     * @return array
     */
    public static function fromTerm(string $language, Terms $term): array
    {
        switch ($language) {
            case "nl":
                return [
                    'id'         => $term->getId(),
                    'term'       => $term->getNl(),
                    'show_price' => $term->getShowPrice(),
                ];
            default:
                return [
                    'id'         => $term->getId(),
                    'term'       => $term->getEn(),
                    'show_price' => $term->getShowPrice(),
                ];
        }
    }

    /**
     * @param string  $language
     * @param Terms[] ...$terms
     *
     * @return array
     */
    public static function fromTerms(string $language, Terms ...$terms): array
    {
        return array_map(
            function (Terms $term) use ($language) {
                return self::fromTerm($language, $term);
            },
            $terms
        );
    }
}
