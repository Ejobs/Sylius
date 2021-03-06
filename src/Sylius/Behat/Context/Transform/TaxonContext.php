<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
final class TaxonContext implements Context
{
    /**
     * @var TaxonRepositoryInterface
     */
    private $taxonRepository;

    /**
     * @param TaxonRepositoryInterface $taxonRepository
     */
    public function __construct(TaxonRepositoryInterface $taxonRepository)
    {
        $this->taxonRepository = $taxonRepository;
    }

    /**
     * @Transform /^classified as "([^"]+)"$/
     * @Transform /^belongs to "([^"]+)"$/
     * @Transform /^"([^"]+)" taxon$/
     * @Transform /^"([^"]+)" as a parent taxon$/
     * @Transform /^"([^"]+)" parent taxon$/
     * @Transform /^parent taxon to "([^"]+)"$/
     * @Transform /^taxon with "([^"]+)" name/
     * @Transform /^taxon "([^"]+)"$/
     */
    public function getTaxonByName($name)
    {
        $taxon = $this->taxonRepository->findOneByName($name);
        Assert::notNull($taxon, sprintf('Taxon with name "%s" does not exist.', $name));

        return $taxon;
    }

    /**
     * @Transform /^taxon with "([^"]+)" code$/
     */
    public function getTaxonByCode($code)
    {
        $taxon = $this->taxonRepository->findOneBy(['code' => $code]);
        Assert::notNull($taxon, sprintf('Taxon with code "%s" does not exist.', $code));

        return $taxon;
    }

    /**
     * @Transform /^classified as "([^"]+)" or "([^"]+)"$/
     */
    public function getTaxonsByNames($firstTaxon, $secondTaxon)
    {
        return [
            $this->getTaxonByName($firstTaxon),
            $this->getTaxonByName($secondTaxon)
        ];
    }
}
