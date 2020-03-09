<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  Library
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Gc\Component;

use Gc\Document\Model as DocumentModel;
use Gc\DocumentType\Model as DocumentTypeModel;
use Gc\Layout\Model as LayoutModel;
use Gc\User\Model as UserModel;
use Gc\View\Model as ViewModel;
use Gc\Registry;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:09.
 *
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class NavigationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Navigation
     */
    protected $object;

    /**
     * @var ViewModel
     */
    protected $view;

    /**
     * @var LayoutModel
     */
    protected $layout;

    /**
     * @var UserModel
     */
    protected $user;

    /**
     * @var DocumentTypeModel
     */
    protected $documentType;

    /**
     * @var DocumentModel
     */
    protected $document;

    /**
     * @var DocumentModel
     */
    protected $documentChildren;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->view = ViewModel::fromArray(
            array(
                'name' => 'View Name',
                'identifier' => 'View identifier',
                'description' => 'View Description',
                'content' => 'View Content'
            )
        );
        $this->view->save();

        $this->layout = LayoutModel::fromArray(
            array(
                'name' => 'Layout Name',
                'identifier' => 'Layout identifier',
                'description' => 'Layout Description',
                'content' => 'Layout Content'
            )
        );
        $this->layout->save();

        $this->user = UserModel::fromArray(
            array(
                'lastname' => 'User test',
                'firstname' => 'User test',
                'email' => 'pierre.rambaud86@gmail.com',
                'login' => 'test',
                'user_acl_role_id' => 1,
            )
        );

        $this->user->setPassword('test');
        $this->user->save();

        $this->documentType = DocumentTypeModel::fromArray(
            array(
                'name' => 'Document Type Name',
                'description' => 'Document Type description',
                'icon_id' => 1,
                'defaultview_id' => $this->view->getId(),
                'user_id' => $this->user->getId(),
            )
        );

        $this->documentType->save();

        $this->document = DocumentModel::fromArray(
            array(
                'name' => 'Document name',
                'url_key' => 'url-key',
                'status' => DocumentModel::STATUS_ENABLE,
                'show_in_nav' => true,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => 0
            )
        );

        $this->document->save();

        $this->documentTwo = DocumentModel::fromArray(
            array(
                'name' => 'Document name',
                'url_key' => 'other-url',
                'status' => DocumentModel::STATUS_ENABLE,
                'show_in_nav' => true,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => 0
            )
        );

        $this->documentTwo->save();

        $this->documentChildren = DocumentModel::fromArray(
            array(
                'name' => 'Document name',
                'url_key' => 'children-key',
                'status' => DocumentModel::STATUS_ENABLE,
                'show_in_nav' => true,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => $this->document->getId()
            )
        );

        $this->documentChildren->save();

        $this->documentThirdChildren = DocumentModel::fromArray(
            array(
                'name' => 'Document name',
                'url_key' => 'url-key',
                'status' => DocumentModel::STATUS_ENABLE,
                'show_in_nav' => true,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => $this->documentChildren->getId()
            )
        );

        $this->documentThirdChildren->save();

        $this->documentSecondChildren = DocumentModel::fromArray(
            array(
                'name' => 'Document name',
                'url_key' => 'second-child-key',
                'status' => DocumentModel::STATUS_ENABLE,
                'show_in_nav' => true,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => $this->documentChildren->getId()
            )
        );

        $this->documentSecondChildren->save();

        $this->documentForthChildren = DocumentModel::fromArray(
            array(
                'name' => 'Document name',
                'url_key' => 'forth-child-key',
                'status' => DocumentModel::STATUS_ENABLE,
                'show_in_nav' => true,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => $this->documentThirdChildren->getId()
            )
        );

        $this->documentForthChildren->save();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        $this->document->delete();
        unset($this->document);

        $this->documentTwo->delete();
        unset($this->documentTwo);

        $this->documentChildren->delete();
        unset($this->documentChildren);

        $this->documentSecondChildren->delete();
        unset($this->documentSecondChildren);

        $this->documentThirdChildren->delete();
        unset($this->documentThirdChildren);

        $this->documentForthChildren->delete();
        unset($this->documentForthChildren);

        $this->view->delete();
        unset($this->view);

        $this->user->delete();
        unset($this->user);

        $this->layout->delete();
        unset($this->layout);

        $this->documentType->delete();
        unset($this->documentType);

        unset($this->object);
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSetBasePath()
    {
        $this->object = new Navigation;
        $this->object->useActiveBranch(true);
        $this->object->setBasePath('/base/path');
        $this->assertEquals('/base/path', $this->object->getBasePath());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetBasePath()
    {
        $this->object = new Navigation;
        $this->object->useActiveBranch(true);
        $this->object->setBasePath('/base/path');
        $this->assertEquals('/base/path', $this->object->getBasePath());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testRender()
    {
        Registry::get('Application')->getRequest()->getUri()->setPath('/url-key/children-key');
        $this->object = new Navigation;
        $this->object->useActiveBranch(true);
        $array = $this->object->render();
        $this->assertTrue(count($array) > 0);
    }

    /**
     * Test
     *
     * @return void
     */
    public function testRenderWithNoActivePage()
    {
        Registry::get('Application')->getRequest()->getUri()->setPath('/other-uri');
        $this->object = new Navigation;
        $this->object->useActiveBranch(true);
        $array = $this->object->render();
        $this->assertTrue(count($array) > 0);
    }

    /**
     * Test
     *
     * @return void
     */
    public function testRenderWithChildrenActivePage()
    {
        Registry::get('Application')->getRequest()->getUri()->setPath('/url-key/url-key/url-key');
        $this->object = new Navigation;
        $this->object->useActiveBranch(true);
        $array = $this->object->render();
        $this->assertTrue(count($array) > 0);
    }

    /**
     * Test
     *
     * @return void
     */
    public function testRenderWithChildrenActivePageOnTheForthDocument()
    {
        Registry::get('Application')->getRequest()->getUri()->setPath('/url-key/children-key/second-child-key');
        $this->object = new Navigation;
        $this->object->useActiveBranch(true);
        $array = $this->object->render();
        $this->assertTrue(count($array) > 0);
    }
}