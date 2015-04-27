<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid\Field;

interface DatagridFieldInterface
{
    /**
     * @return \Wanjee\Shuwee\AdminBundle\Datagrid\Type\DatagridTypeInterface
     */
    public function getType();

    /**
     * @return string
     */
    public function getName();

    /**
     * Get label from type options
     * @return string The label for the current field
     */
    public function getLabel();

    /**
     * @param mixed $row
     * @return mixed
     */
    public function getData($row);
}