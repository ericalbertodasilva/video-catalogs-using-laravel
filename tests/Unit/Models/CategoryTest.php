<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    private $category;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this -> category = new Category();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }

    public function testeIfUseTraits(){
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testFillableAttribute()
    {
        $fillable = ['name','description','is_active'];
        $this -> assertEquals( $fillable, $this->category->getFillable());
    }

    public function testDateAttribute()
    {
        $dates = ['deleted_at','created_at','updated_at'];
        $datesCategory = $this->category->getDates();
        foreach($dates as $date){
            $this->assertContains($date, $datesCategory);
        };
        $this->assertCount(count($dates),$datesCategory);
    }
    
    public function testCasts()
    {
        $casts = ['id'=>'string', 'is_active'=>'boolean'];
        $this -> assertEquals( $casts, $this->category->getCasts());
    }

    public function testIncrementing()
    {
        $this -> assertFalse($this->category->incrementing);
    }
}
