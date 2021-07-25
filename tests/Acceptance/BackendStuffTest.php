<?php
declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Models\Category;

class BackendStuffTest extends \PHPUnit\Extensions\Selenium2TestCase
{
    public static function setUpBeforeClass(): void
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection(
            [
                'driver'    => 'sqlite',
                'host'      => 'localhost',
                'database'  => '/var/www/php-unit-course/data/db.sqlite',
                'username'  => 'user',
                'password'  => 'password',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]
        );
        $capsule->setAsGlobal(); // allow static methods
        $capsule->bootEloquent(); // setup the Eloquent ORM

        $capsule::schema()->dropIfExists('categories');

        $capsule::schema()->create(
            'categories',
            function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable(false);
                $table->text('description')->nullable(false);
                $table->bigInteger('parent_id')->unsigned()->nullable();
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            }
        );
    }

    protected function setUp(): void
    {
        $this->setHost('selenium');
        $this->setBrowserUrl('http://php-unit-course.loc');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(
            ['chromeOptions' => ['w3c' => false]]
        ); // phpunit-selenium does not support W3C mode yet
    }

    public function testCanSeeAddedCategories(): void
    {

        Category::create(['name' => 'Electronics', 'description' => 'Description of Electronics']);
        $this->url('');

        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/a');
        $href = $element->attribute('href');
        $this->assertRegExp('@^http://php-unit-course.loc/show-category/[0-9]+,Electronics@', $href);

        $this->url('/show-category/1');
        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/a');
        $href = $element->attribute('href');
        $this->assertRegExp('@^http://php-unit-course.loc/show-category/[0-9]+,Electronics@', $href);
    }

    /**
     * @depends testCanSeeAddedCategories
     */
    public function testCanAddChildCategory(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $electronics->children()->saveMany(
            [
                new Category(['name' => 'Monitors', 'description' => 'Description of Monitors']),
                new Category(['name' => 'Tablets', 'description' => 'Description of Tablets']),
                new Category(['name' => 'Computers', 'description' => 'Description of Computers']),
            ]
        );

        $computers = Category::where('name', 'Computers')->first();
        $computers->children()->saveMany(
            [
                new Category(['name' => 'Desktops', 'description' => 'Description of Desktops']),
                new Category(['name' => 'Notebooks', 'description' => 'Description of Notebooks']),
                new Category(['name' => 'Laptops', 'description' => 'Description of Laptops']),
            ]
        );

        $laptops = Category::where('name', 'Laptops')->first();
        $laptops->children()->saveMany(
            [
                new Category(['name' => 'Asus', 'description' => 'Description of Asus']),
                new Category(['name' => 'Dell', 'description' => 'Description of Dell']),
                new Category(['name' => 'Acer', 'description' => 'Description of Acer']),
            ]
        );

        $acer = Category::where('name', 'Acer')->first();
        $acer->children()->saveMany(
            [
                new Category(['name' => 'FullHD', 'description' => 'Description of FullHD']),
                new Category(['name' => 'HD+', 'description' => 'Description of HD+']),
            ]
        );

        Category::create(
            [
                'name'        => 'Videos',
                'description' => 'Description of Videos',
            ]
        );
        Category::create(
            [
                'name'        => 'Software',
                'description' => 'Description of Software',
            ]
        );

        $software = Category::where('name', 'Software')->first();
        $software->children()->saveMany(
            [
                new Category(['name' => 'Operating systems', 'description' => 'Description of Operating systems']),
                new Category(['name' => 'Servers', 'description' => 'Description of Servers']),
            ]
        );

        $operating_systems = Category::where('name', 'Operating systems')->first();
        $operating_systems->children()->saveMany(
            [
                new Category(['name' => 'Linux', 'description' => 'Description of Linux']),
            ]
        );

        $this->url('');

        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]/li[1]/a');
        $href = $element->attribute('href');
        $this->assertRegExp('@^http://php-unit-course.loc/show-category/[0-9]+,Monitors$@', $href);

    }

    /**
     * @depends testCanAddChildCategory
     */
    public function testCanSeePopulatedFormDataWhenCategoryIsEdited(): void
    {
        $this->url('/edit-category/17');

        $categoryDescription = $this->byName('description');
        self::assertSame('Description of Linux', $categoryDescription->text());

        $categoryName = $this->byName('name');
        self::assertSame('Linux', $categoryName->value());

    }

    /**
     * На страницы редактирования категории в списке select правильно выбрана родительская категория
     * @depends testCanAddChildCategory
     */
    public function testCanSeeCorrectSelectedParentCategoryWhenEditChildCategory(): void
    {
        $this->url('/edit-category/17');
        $categoriesList = $this->byId('categories-list');

        self::assertSame('15', $this->select($categoriesList)->selectedValue());

    }

    /**
     * @depends testCanAddChildCategory
     */
    public function testCanEditCategory(): void
    {
        $this->url('/edit-category/6'); // Notebooks

        $categoryName = $this->byName('name');
        $categoryName->clear();
        $categoryName->value('NotebookEdited');

        $categoryDescription = $this->byName('description');
        $categoryDescription->clear();
        $categoryDescription->value('Description of NotebookEdited');

        $categoriesList = $this->byId('categories-list');
        $this->select($categoriesList)->selectOptionByValue('3'); // Electronics -> Tablets

        $button = $this->byCssSelector('input[type="submit"]');
        $button->click();

        $this->url('');

        self::assertStringNotContainsString('Notebooks', $this->source());

    }

    /**
     *
     */
    public function testCanAddCategory(): void
    {
        $this->url('');
        $this->byName('name')->value('New category');
        $this->byName('description')->value('Description of New category');
        $submit = $this->byCssSelector('input[type="submit"]');
        $submit->submit();

        self::assertStringContainsString('New category', $this->source());
    }
}