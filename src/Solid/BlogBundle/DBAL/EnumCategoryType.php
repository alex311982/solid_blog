<?php
namespace Solid\BlogBundle\DBAL;

class EnumCategoryType extends EnumType
{
    protected $name = 'enumcategory';
    protected $values = array('Category 1', 'Category 2');

    public static $staticValues = array('Category 1', 'Category 2');
}