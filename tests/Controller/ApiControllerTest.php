<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Organization\tests\Controller;

use Model\CoreSettings;
use Modules\Admin\Models\AccountPermission;
use Modules\Organization\Models\Status;
use Modules\Organization\Models\UnitMapper;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\System\MimeType;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\TestUtils;

/**
 * @internal
 */
class ApiControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $app    = null;

    protected $module = null;

    protected function setUp() : void
    {
        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $this->app->dbPool         = $GLOBALS['dbpool'];
        $this->app->orgId          = 1;
        $this->app->accountManager = new AccountManager($GLOBALS['session']);
        $this->app->appSettings    = new CoreSettings($this->app->dbPool->get());
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../../Modules/');
        $this->app->dispatcher     = new Dispatcher($this->app);
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/../../../Web/Api/Hooks.php');

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission = new AccountPermission();
        $permission->setUnit(1);
        $permission->setApp('backend');
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new WebRouter();

        $this->module = $this->app->moduleManager->get('Organization');

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitGet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', '1');

        $this->module->apiUnitGet($request, $response);

        self::assertEquals('Orange-Management', $response->get('')['response']->name);
        self::assertGreaterThan(0, $response->get('')['response']->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitSet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', '1');
        $request->setData('name', 'OMS');

        $this->module->apiUnitSet($request, $response);
        $this->module->apiUnitGet($request, $response);

        self::assertEquals('OMS', $response->get('')['response']->name);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitFind() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('search', 'OMS');

        $this->module->apiUnitFind($request, $response);

        self::assertEquals('OMS', $response->get('')[0]->name);
        self::assertGreaterThan(0, $response->get('')[0]->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitCreateDelete() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('name', 'test');
        $request->setData('status', Status::INACTIVE);
        $request->setData('description', 'test description');

        $this->module->apiUnitCreate($request, $response);

        self::assertEquals('test', $response->get('')['response']->name);
        self::assertGreaterThan(0, $response->get('')['response']->getId());

        // test delete
        $request->setData('id', $response->get('')['response']->getId());
        $this->module->apiUnitDelete($request, $response);

        self::assertGreaterThan(0, $response->get('')['response']->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitCreateInvalid() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;

        $this->module->apiUnitCreate($request, $response);

        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    protected static $departmentId = 0;

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiDepartmentCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('name', 'test');
        $request->setData('status', Status::INACTIVE);
        $request->setData('unit', 1);
        $request->setData('description', 'test description');

        $this->module->apiDepartmentCreate($request, $response);

        self::assertEquals('test', $response->get('')['response']->name);
        self::assertGreaterThan(0, $response->get('')['response']->getId());

        self::$departmentId = $response->get('')['response']->getId();
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiDepartmentFind() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('search', 'test');

        $this->module->apiDepartmentFind($request, $response);

        self::assertEquals('test', $response->get('')[0]->name);
        self::assertGreaterThan(0, $response->get('')[0]->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiDepartmentCreateInvalid() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;

        $this->module->apiDepartmentCreate($request, $response);

        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiDepartmentGet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$departmentId);

        $this->module->apiDepartmentGet($request, $response);

        self::assertEquals('test', $response->get('')['response']->name);
        self::assertGreaterThan(0, $response->get('')['response']->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiDepartmentSet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$departmentId);
        $request->setData('name', 'Production');

        $this->module->apiDepartmentSet($request, $response);
        $this->module->apiDepartmentGet($request, $response);

        self::assertEquals('Production', $response->get('')['response']->name);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiDepartmentDelete() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$departmentId);
        $this->module->apiDepartmentDelete($request, $response);

        self::assertGreaterThan(0, $response->get('')['response']->getId());
    }

    protected static $positionId = 0;

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiPositionCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('name', 'test');
        $request->setData('status', Status::INACTIVE);
        $request->setData('description', 'test description');

        $this->module->apiPositionCreate($request, $response);

        self::assertEquals('test', $response->get('')['response']->name);
        self::assertGreaterThan(0, $response->get('')['response']->getId());
        self::$positionId = $response->get('')['response']->getId();
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiPositionFind() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('search', 'test');

        $this->module->apiPositionFind($request, $response);

        self::assertEquals('test', $response->get('')[0]->name);
        self::assertGreaterThan(0, $response->get('')[0]->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiPositionCreateInvalid() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;

        $this->module->apiPositionCreate($request, $response);

        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiPositionGet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$positionId);

        $this->module->apiPositionGet($request, $response);

        self::assertEquals('test', $response->get('')['response']->name);
        self::assertGreaterThan(0, $response->get('')['response']->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiPositionSet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$positionId);
        $request->setData('name', 'Test');

        $this->module->apiPositionSet($request, $response);
        $this->module->apiPositionGet($request, $response);

        self::assertEquals('Test', $response->get('')['response']->name);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiPositionDelete() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$positionId);
        $this->module->apiPositionDelete($request, $response);

        self::assertGreaterThan(0, $response->get('')['response']->getId());
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitImageSet() : void
    {
        \copy(__DIR__ . '/icon.png', __DIR__ . '/temp_icon.png');

        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('name', 'Organization Logo');
        $request->setData('id', 1);

        TestUtils::setMember($request, 'files', [
            'file1' => [
                'name'     => 'icon.png',
                'type'     => MimeType::M_PNG,
                'tmp_name' => __DIR__ . '/temp_icon.png',
                'error'    => \UPLOAD_ERR_OK,
                'size'     => \filesize(__DIR__ . '/icon.png'),
            ],
        ]);
        $this->module->apiUnitImageSet($request, $response);

        $image = UnitMapper::get(1)->image;
        self::assertEquals('Organization Logo', $image->name);
    }

    /**
     * @covers Modules\Organization\Controller\ApiController
     * @group module
     */
    public function testApiUnitImageSetInvalid() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $this->module->apiUnitImageSet($request, $response);

        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
