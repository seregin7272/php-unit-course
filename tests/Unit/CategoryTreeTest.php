<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\CategoryTree;
use App\Services\HtmlList;
use PHPUnit\Framework\TestCase;

class CategoryTreeTest extends TestCase
{
    protected CategoryTree $categoryTree;

    protected function setUp(): void
    {
        $this->categoryTree = new CategoryTree();
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanConvertDatabaseResultToCategoryNestedArray($afterConversion, $dbResult): void
    {
        $this->assertEquals($afterConversion, $this->categoryTree->convert($dbResult));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanProduceHtmlUlNestedCategories($afterConversion, $dbResult, $htmlList): void
    {
        $html = new HtmlList;
        $afterConversionDb = $html->convert($dbResult);
        $this->assertEquals($htmlList, $html->makeUlList($afterConversionDb));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanProduceHtmlSelectNestedCategories($afterConversion, $dbResult, $htmlList, $htmlSelect): void
    {
        $html = new HtmlList;
        $afterConversionDb = $html->convert($dbResult);
        $this->assertEquals($htmlSelect, $html->makeSelectList($afterConversionDb));
    }

    public function arrayProvider(): array
    {
        return [
//            'one level' => [
//                [
//                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null, 'children'=>[]],
//                    ['id'=>2, 'name'=>'Videos', 'parent_id'=>null, 'children'=>[]],
//                    ['id'=>3, 'name'=>'Software', 'parent_id'=>null, 'children'=>[]]
//                ],
//                [
//                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
//                    ['id'=>2, 'name'=>'Videos', 'parent_id'=>null],
//                    ['id'=>3, 'name'=>'Software', 'parent_id'=>null]
//                ],
//                '<li><a href="http://php-unit-course.loc/show-category/1,Electronics">Electronics</a></li><li><a href="http://php-unit-course.loc/show-category/2,Videos">Videos</a></li><li><a href="http://php-unit-course.loc/show-category/3,Software">Software</a></li>',
//                [
//                    ['id'=>1, 'name'=>'Electronics'],
//                    ['id'=>2, 'name'=>'Videos'],
//                    ['id'=>3, 'name'=>'Software']
//                ]
//
//            ],
            'two level' => [
                [
                    [
                        'id'=>1,
                        'name'=>'Electronics',
                        'parent_id'=>null,
                        'children'=>
                            [
                                [
                                    'id'=>2,
                                    'name'=>'Computers',
                                    'parent_id'=>1,
                                    'children'=>[]
                                ]
                            ]
                    ],
                    ['id'=>3, 'name'=>'Videos', 'parent_id'=>null, 'children'=>[]],
                ],
                [
                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
                    ['id'=>3, 'name'=>'Videos', 'parent_id'=>null],
                    ['id'=>2, 'name'=>'Computers', 'parent_id'=>1]
                ],
                '<li><a href="http://php-unit-course.loc/show-category/1,Electronics">Electronics</a><ul class="submenu menu vertical" data-submenu><li><a href="http://php-unit-course.loc/show-category/2,Computers">Computers</a></li></ul></li><li><a href="http://php-unit-course.loc/show-category/3,Videos">Videos</a></li>',
                [
                    ['id'=>1, 'name'=>'Electronics'],
                    ['id'=>2, 'name'=>'&nbsp;&nbsp;Computers'],
                    ['id'=>3, 'name'=>'Videos'],
                ]
            ],
            'three level' => [
                [
                    [
                        'id'=>1,
                        'name'=>'Electronics',
                        'parent_id'=>null,
                        'children'=>
                            [
                                [
                                    'id'=>2,
                                    'name'=>'Computers',
                                    'parent_id'=>1,
                                    'children'=>
                                        [
                                            [
                                                'id'=>3,
                                                'name'=>'Laptops',
                                                'parent_id'=>2,
                                                'children'=>[]
                                            ]
                                        ]
                                ]
                            ]
                    ]
                ],
                [
                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
                    ['id'=>2, 'name'=>'Computers', 'parent_id'=>1],
                    ['id'=>3, 'name'=>'Laptops', 'parent_id'=>2],
                ],
                '<li><a href="http://php-unit-course.loc/show-category/1,Electronics">Electronics</a><ul class="submenu menu vertical" data-submenu><li><a href="http://php-unit-course.loc/show-category/2,Computers">Computers</a><ul class="submenu menu vertical" data-submenu><li><a href="http://php-unit-course.loc/show-category/3,Laptops">Laptops</a></li></ul></li></ul></li>',
                [
                    ['id'=>1, 'name'=>'Electronics'],
                    ['id'=>2, 'name'=>'&nbsp;&nbsp;Computers'],
                    ['id'=>3, 'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;Laptops'],
                ]
            ],
        ];
    }
}