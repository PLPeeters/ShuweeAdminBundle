<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid\Field;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Class DatagridField
 * @package Wanjee\Shuwee\AdminBundle\Datagrid\Field
 */
class DatagridField implements DatagridFieldInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Wanjee\Shuwee\AdminBundle\Datagrid\Type\DatagridTypeInterface
     */
    protected $type;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param string $name
     * @param \Wanjee\Shuwee\AdminBundle\Datagrid\Type\DatagridTypeInterface $type
     * @param array $options
     */
    function __construct($name, $type, $options = array())
    {
        $this->name = $name;
        $this->type = $type;

        $this->setOptions($options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Wanjee\Shuwee\AdminBundle\Datagrid\Type\DatagridTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $options
     */
    function setOptions($options = array())
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label' => null,
        ));
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * @param string $name
     * @param mixed $default
     */
    public function getOption($name, $default = null)
    {
        if ($this->hasOption($name)) {
            return $this->options[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     *
     */
    public function getLabel()
    {
        if ($label = $this->getOption('label', null)) {
            return $label;
        }

        // defaults to column name
        return $this->name;
    }

    /**
     * @param mixed $row
     * @return mixed
     */
    public function getData($entity)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $value = $accessor->getValue($entity, $this->name);
        return $value;
    }

}