<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\CoreBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\CoreBundle\Form\Type\ImageType;
use Sylius\Bundle\CoreBundle\Form\Type\TaxonImageType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\TaxonomyBundle\Form\EventListener\BuildTaxonFormSubscriber;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @mixin TaxonImageType
 *
 * @author Grzegorz Sadowski <grzegorz.sadowski@lakion.com>
 */
final class TaxonImageTypeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('TaxonImage', []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TaxonImageType::class);
    }

    function it_is_a_form_type()
    {
        $this->shouldImplement(FormTypeInterface::class);
    }

    function it_extends_image_form_type()
    {
        $this->shouldHaveType(ImageType::class);
    }

    function it_builds_form_with_proper_fields(FormBuilderInterface $builder, FormFactoryInterface $factory)
    {
        $builder->getFormFactory()->willReturn($factory);

        $builder->add('file', 'file', Argument::any())
            ->shouldBeCalled()
            ->willReturn($builder)
        ;

        $builder->add('code', 'text', Argument::any())
            ->shouldBeCalled()
            ->willReturn($builder)
        ;

        $this->buildForm($builder, []);
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('sylius_taxon_image');
    }
}
