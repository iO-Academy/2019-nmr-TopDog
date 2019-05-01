<?php
require_once '../../../vendor/autoload.php';

use PHPUnit\Framework\Testcase;

class DataProcessorTest extends Testcase
{
    public function testInternalType()
    {
        $APIGrabber = $this->createMock(TopDog\scraper\Classes\APIGrabber::class);
        $dataProcessor = new TopDog\scraper\Classes\DataProcessor($APIGrabber);
        $this->assertInternalType('object', $dataProcessor);
    }

    public function testCreateImageUrlSuccessWithSubBreed()
    {
        $APIGrabber = $this->createMock(TopDog\scraper\Classes\APIGrabber::class);
        $dataProcessor = new TopDog\scraper\Classes\DataProcessor($APIGrabber);
        $test = [['id'=>'1', 'breed_name'=>'cat', 'sub_breed'=>'big'], ['id'=>'2', 'breed_name'=>'megacat', 'sub_breed'=>'tiny']];
        $result = $dataProcessor->createImageUrlWithId($test);
        $this->assertEquals([['id'=>'1', 'urlRequest'=>'https://dog.ceo/api/breed/cat-big/images'], ['id'=>'2', 'urlRequest'=>'https://dog.ceo/api/breed/megacat-tiny/images']], $result);
    }

    public function testCreateImageUrlSuccessNoSubBreed()
    {
        $APIGrabber = $this->createMock(TopDog\scraper\Classes\APIGrabber::class);
        $dataProcessor = new TopDog\scraper\Classes\DataProcessor($APIGrabber);
        $test = [['id'=>'1', 'breed_name'=>'cat', 'sub_breed'=>''], ['id'=>'2', 'breed_name'=>'megacat', 'sub_breed'=>'']];
        $result = $dataProcessor->createImageUrlWithId($test);
        $this->assertEquals([['id'=>'1', 'urlRequest'=>'https://dog.ceo/api/breed/cat/images'], ['id'=>'2', 'urlRequest'=>'https://dog.ceo/api/breed/megacat/images']], $result);
    }

    public function testCreateImageUrlFailure()
    {
        $APIGrabber = $this->createMock(TopDog\scraper\Classes\APIGrabber::class);
        $dataProcessor = new TopDog\scraper\Classes\DataProcessor($APIGrabber);
        $test = [[]];
        $result = $dataProcessor->createImageUrlWithId($test);
        $this->assertEquals([], $result);
    }

    public function testCreateImageUrlMalformed()
    {
        $APIGrabber = $this->createMock(TopDog\scraper\Classes\APIGrabber::class);
        $dataProcessor = new TopDog\scraper\Classes\DataProcessor($APIGrabber);
        $test = 'Hello Chad!';
        $this->expectException(TypeError::class);
        $dataProcessor->createImageUrlWithId($test);
    }

    public function testCreateImageUrlMalformedInteger()
    {
        $APIGrabber = $this->createMock(TopDog\scraper\Classes\APIGrabber::class);
        $dataProcessor = new TopDog\scraper\Classes\DataProcessor($APIGrabber);
        $test = 1;
        $this->expectException(TypeError::class);
        $dataProcessor->createImageUrlWithId($test);
    }
}