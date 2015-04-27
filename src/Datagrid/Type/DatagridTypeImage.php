<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DatagridTypeImage
 * @package Wanjee\Shuwee\AdminBundle\Datagrid\Type
 */
class DatagridTypeImage extends DatagridType
{
    /**
     * Get administrative name of this type
     * @return string Name of the type
     */
    public function getName()
    {
        return 'datagrid_image';
    }

    /**
     * Get template block name for this type
     * @return string Block name (must be a valid block name as defined in Twig documentation)
     */
    public function getBlockName()
    {
        return 'datagrid_image';
    }

    /**
     * Get prepared view parameters
     *
     * @param \Wanjee\Shuwee\AdminBundle\Datagrid\Field\DatagridFieldInterface $field
     * @param mixed $entity Instance of a model entity
     *
     * @return mixed
     */
    public function getBlockVariables($field, $entity)
    {
        $base_path = $this->getOption('base_path', 'uploads');

        return array(
            'value' => $base_path . '/' . $field->getData($entity),
        );
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('base_path', 'uploads');
        $resolver->setRequired('base_path');
    }
}