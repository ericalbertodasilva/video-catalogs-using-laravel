<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $this->assertCount(1,$genres);
        $genresKeys = array_Keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id', 
                'name',  
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at' 
            ], 
            $genresKeys
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genre->refresh();

        $this->assertEquals('test1',$genre->name);
        $this->assertNull($genre->description);
        $this->assertTrue($genre->is_active);

        preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $genre->id, $matches);
        $this->assertEquals(1,count($matches));

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => true
        ]);

        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'is_active'=>false
        ])->first();

        $data = [
            'name'=>'test_description',
            'is_active'=>true
        ];

        $genre->update($data);

        foreach($data as $key => $value)
        {
            $this->assertEquals($value, $genre->{$key});
        }

    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();
        $this->assertNull($genre->deleted_at);
        
        $genre->delete();
        $this->assertSoftDeleted($genre);
        
        $genre->restore();
        $this->assertNotNull(Genre::find($genre->id));
    }
}
