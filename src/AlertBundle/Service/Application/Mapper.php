<?php
declare(strict_types = 1);

namespace AlertBundle\Service\Application;

use AlertBundle\Entity\Application;

/**
 * Class Mapper
 */
class Mapper
{
    /**
     * @param Application $application
     *
     * @return array
     */
    public static function fromApplication(Application $application): array
    {
        switch ($application->getCountry()) {
            case "NL":
                $kind    = $application->getKind()->getNl();
                $subtype = $application->getSubType()->getNl();
                $terms   = $application->getTerms()->getNl();
                break;
            default:
                $kind    = $application->getKind()->getEn();
                $subtype = $application->getSubType()->getEn();
                $terms   = $application->getTerms()->getEn();
                break;
        }

        return [
            'id'           => $application->getId(),
            'applicant_id' => $application->getApplicant()->getId(),
            'kind_id'      => $application->getKind()->getId(),
            'kind_name'    => $kind,
            'postcode'     => $application->getPostcode(),
            'country'      => $application->getCountry(),
            'distance'     => $application->getDistance(),
            'min_price'    => $application->getMinPrice(),
            'max_price'    => $application->getMaxPrice(),
            'rooms'        => $application->getRooms(),
            'subtype_id'   => $application->getSubType()->getId(),
            'subtype_name' => $subtype,
            'terms_id'     => $application->getTerms()->getId(),
            'terms_name'   => $terms,
            'active'       => $application->getActive(),
        ];
    }

    /**
     * @param Application[] ...$applications
     *
     * @return array
     */
    public static function fromApplications(Application ...$applications): array
    {
        return array_map(
            function (Application $application) {
                return self::fromApplication($application);
            },
            $applications
        );
    }
}
