<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1,$categories);
        $categoriesKeys = array_Keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id', 
                'name',  
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at' 
            ], 
            $categoriesKeys
        );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test1'
        ]);
        $category->refresh();

        $this->assertEquals('test1',$category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
        
        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);

        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);

        $this->assertEquals('test_description',$category->description);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);

        $this->assertTrue($category->is_active);
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description'=>'test_description',
            'is_active'=>false
        ])->first();

        $data = [
            'name'=>'test_description',
            'description'=>'test_description_updated',
            'is_active'=>true
        ];

        $category->update($data);

        foreach($data as $key => $value)
        {
            $this->assertEquals($value, $category->{$key});
        }

    }

    public function testDelete()
    {   
        $category = factory(Category::class)->create();
        $this->assertNull($category->deleted_at);
        
        $category->delete();
        $this->assertSoftDeleted($category);

        $category->restore();
        $this->assertNotNull(Category::find($category->id));
    }
}
