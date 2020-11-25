<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    private $genre;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this -> genre = new Genre();
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
        $genreTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);
    }

    public function testFillableAttribute()
    {
        $fillable = ['name','is_active'];
        $this -> assertEquals( $fillable, $this->genre->getFillable());
    }

    public function testDateAttribute()
    {
        $dates = ['deleted_at','created_at','updated_at'];
        $datesGenre = $this->genre->getDates();
        $this->assertEqualsCanonicalizing($dates,$datesGenre);
        $this->assertCount(count($dates),$datesGenre);
    }
    
    public function testCasts()
    {
        $casts = ['id'=>'string', 'is_active'=>'boolean'];
        $this -> assertEquals( $casts, $this->genre->getCasts());
    }

    public function testIncrementing()
    {
        $this -> assertFalse($this->genre->incrementing);
    }
}
