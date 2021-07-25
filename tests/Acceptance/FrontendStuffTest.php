<?php
declare(strict_types=1);

namespace App\Tests\Acceptance;

class FrontendStuffTest extends \PHPUnit\Extensions\Selenium2TestCase
{
    protected function setUp(): void
    {
        $this->setHost('selenium');
        $this->setBrowserUrl('http://php-unit-course.loc');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(
            ['chromeOptions' => ['w3c' => false]]
        ); // phpunit-selenium does not support W3C mode yet
    }

    /**
     * Проверка загрузке главной страницы
     */
    public function testCanSeeCorrectStringsOnMainPage(): void
    {
        $this->url('');

        self::assertNotEmpty($this->byClassName('top-bar'));
        self::assertStringContainsString('Добавить новую категорию', $this->source());
    }

    public function testCanSeeEditAndDeleteLinksAndCategoryName(): void
    {
        $this->url('');
        $electronics = $this->byLinkText('Electronics');
        $electronics->click();

        $h5 = $this->byCssSelector('div.basic-card-content h5');
        $this->assertStringContainsString('Electronics', $h5->text());

        $p = $this->byCssSelector('div.basic-card-content p');
        $this->assertStringContainsString('Description of Electronics', $p->text());

        $editLink = $this->byLinkText('Edit');
        $href = $editLink->attribute('href');
        $this->assertStringContainsString('/edit-category/1', $href);

        $deleteLink = $this->byLinkText('Delete');
        $href = $deleteLink->attribute('href');
        $this->assertStringContainsString('/delete-category/1', $href);
    }

    /**
     * Проверка нажатия на кнопку редактировать
     */
    public function testCanSeeCorrectEditTitle(): void
    {
        $this->url('/show-category/1');

        $editLink = $this->byLinkText('Edit');
        $editLink->click();

        self::assertStringContainsString('Редактировать категорию', $this->source());
    }

    /**
     * Проверка отправки формы для сохранения категории
     */
    public function testCanSeeInvalidateForm(): void
    {
        $this->url('');

       $submit = $this->byCssSelector('input[type="submit"]');
       $submit->submit();
       self::assertStringContainsString('Правильно заполните форму', $this->source());
    }

    public function testCanSeeCorrectValidateForm(): void
    {
        $this->url('');
        $this->byName('name')->value('Новая категория');
        $this->byName('description')->value('description');
        $submit = $this->byCssSelector('input[type="submit"]');
        $submit->submit();
        self::assertStringContainsString('Категория сохранена', $this->source());
    }

    /**
     *  Можно увидеть список select для выбора категорий
     */
    public function testCanSeeSelectOptionsList(): void
    {
        $this->url('');

        self::assertStringContainsString('&nbsp;&nbsp;&nbsp;&nbsp;Laptops', $this->source());
    }

    /**
     * Проверка меню на вложенные категории
     */
    public function testCanSeeNestedCategories(): void
    {
        $this->url('');

        // Количество пуктов в меню
        $categories = $this->elements($this->using('css selector')->value('ul.dropdown li'));
        $this->assertCount(20, $categories);


        // Первый уровень в меню
        $elem1 = $this->byCssSelector('ul.dropdown > li:nth-child(2) > a');
        $this->assertEquals('Electronics',$elem1->text());

        $elem2 = $this->byCssSelector('ul.dropdown > li:nth-child(3) > a');
        $this->assertEquals('Videos',$elem2->text());

        $elem3 = $this->byCssSelector('ul.dropdown > li:nth-child(4) > a');
        $this->assertEquals('Software',$elem3->text());


        // Второй уровень
        // $elem4 = $this->byCssSelector('ul.dropdown > :nth-child(2) > :nth-child(2) > :nth-child(1) > a');
        $elem4 = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]/li[1]/a');
        $href = $elem4->attribute('href');
        $this->assertRegExp('@^http://php-unit-course.loc/show-category/[0-9]+,Monitors$@',$href);


        // 4 Уровень
        $elem5 = $this->byXPath('//ul[@class="dropdown menu"]/li[2]//ul[1]//ul[1]//ul[1]//ul[1]/li[1]/a');
        $href = $elem5->attribute('href');
        $this->assertRegExp('@^http://php-unit-course.loc/show-category/[0-9]+,FullHD@',$href);
    }

    /**
     * Окно подврждения после нажатия на ссылку удалить
     */
    public function testCanSeeConfirmDialogWhenTryingDeleteCategory(): void
    {
        $this->url('/show-category/18');
        $this->clickOnElement('delete-category-link');

        // Ждем пока не появится окно или не пройдет 4сек
        $this->waitUntil(
            function () {
                if ($this->alertIsPresent()) {
                    return true;
                }

                return null;

            },
            4000
        );

        $this->dismissAlert();

        self::assertTrue(true);
    }

    /**
     * Сообщение после удаления категории
     */
    public function testCanSeeCorrectMessageAfterDeletingCategory(): void
    {
        $this->url('/show-category/1');
        $this->clickOnElement('delete-category-link');

        // Ждем пока не появится окно или не пройдет 4сек
        $this->waitUntil(
            function () {
                if ($this->alertIsPresent()) {
                    return true;
                }

                return null;

            },
            4000
        );

        $this->acceptAlert();

        self::assertStringContainsString('Категория успешно удалена', $this->source());

        // Проверка что удалены и дочернии категории
        $this->url('');
        $this->assertNotRegExp('@Computers</a>@',$this->source());
    }

}