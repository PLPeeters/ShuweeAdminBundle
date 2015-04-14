Shuwee
======

Shuwee is (or will be) a backend administration application (yes, one more) for your websites or RESTFUL apps.

Features will include:

- CRUD capabilities
- Nice backend interface
- REST API
- And much more

**Warning:** This is still a total work in progress.  This is not yet supposed to be used in real world.

Documentation
-------------

The bulk of the documentation will be stored in the `Resources/doc/index.md`

License
-------

This work is under the MIT license.

Why "Shuwee" ?
--------------

Shuwee name comes from a Lakota word : čhuwí.  It's defined as the upper back of the body.


Getting Started
===============


Installation
------------

Add ShuweeAdminBundle in your composer.json

.. code-block:: javascript

    {
        "require": {
            "wanjee/shuwee-admin-bundle": "dev-master"
        }
    }

Ask composer to install the bundle and its dependencies

.. code-block:: bash

    composer update wanjee/shuwee-admin-bundle

Register ShuweeAdminBundle and KnpMenuBundle in AppKernel.php

.. code-block:: php

    new Knp\Bundle\MenuBundle\KnpMenuBundle(),
    new Wanjee\Shuwee\AdminBundle\ShuweeAdminBundle(),

Add ShuweeAdminBundle to the list of Assetic supported bundles in config.yml (or comment the bundles line)

.. code-block:: yaml

    assetic:
        debug:          "%kernel.debug%"
        use_controller: false
        #bundles:        [ ]

Bundle usage
------------

Add ShuweeAdminBundle routing in app/config/routing.yml

.. code-block:: yaml

    shuwee_admin:
        resource: "@ShuweeAdminBundle/Resources/config/routing.yml"
        prefix: /admin

Define or generate form type for your entity.

.. code-block:: bash

    bin/console generate:doctrine:form AcmeDemoBundle:Post


Define admin services in your bundle.  

.. code-block:: php

    <?php
    namespace Acme\Bundle\DemoBundle\Admin;
    
    use Wanjee\Shuwee\AdminBundle\Admin\Admin;
    use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;
    
    /**
     * Class PostAdmin
     * @package Acme\Bundle\DemoBundle\Admin
     */
    class PostAdmin extends Admin
    {
        /**
         * Return the main admin form for this content
         *
         * @return \Symfony\Component\Form\Form
         */
        public function getForm()
        {
            return 'Acme\Bundle\DemoBundle\Form\PostType';
        }
    
        /**
         * @return Datagrid
         */
        public function getDatagrid()
        {
            $datagrid = new Datagrid($this);
    
            $datagrid
              ->addField('id', 'text')
              ->addField('title', 'text');
    
            return $datagrid;
        }
    
        /**
         * @return string
         */
        public function getEntityName()
        {
            return 'AcmeDemoBundle:Post';
        }
    
        /**
         * @return string
         */
        public function getEntityClass()
        {
            return 'Acme\Bundle\DemoBundle\Entity\Post';
        }
    
        /**
         * @return string
         */
        public function getLabel()
        {
            return '{0} Posts|{1} Post|]1,Inf] Posts';
        }
    }

Register your admin class as a tagged service

.. code-block:: yaml

    acmedemo.post_admin:
        class: Acme\Bundle\DemoBundle\Admin\PostAdmin
        parent: shuwee_admin.admin_abstract
        tags:
          -  { name: shuwee.admin, alias: post }