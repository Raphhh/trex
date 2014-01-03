<?php
namespace TRex\Serialization;

class HasherTest extends \PHPUnit_Framework_TestCase
{

    public function testHash()
    {
        $this->assertSame(sha1('test'), Hasher::hash(new HashMethod(HashMethod::SHA1), 'test'));
    }

    public function testHashClass()
    {
        $hasher = new Hasher();
        $this->assertSame(40, strlen($hasher->hashClass(new Hasher())));
        $this->assertSame($hasher->hashClass(new Hasher()), $hasher->hashClass(new Hasher()));
        $this->assertSame(
            $hasher->hashClass(new Hasher()),
            $hasher->hashClass(new Hasher(new HashMethod(HashMethod::MD5)))
        );
    }

    public function testHashObject()
    {
        $hasher = new Hasher();
        $this->assertSame(40, strlen($hasher->hashObject(new Hasher())));
        $this->assertSame($hasher->hashObject(new Hasher()), $hasher->hashObject(new Hasher()));
        $this->assertNotSame(
            $hasher->hashObject(new Hasher()),
            $hasher->hashObject(new Hasher(new HashMethod(HashMethod::MD5)))
        );
    }

    public function testHashArray()
    {
        $hasher = new Hasher();
        $this->assertSame(40, strlen($hasher->hashObject(new Hasher())));
        $this->assertSame($hasher->hashArray(array('a', 'b')), $hasher->hashArray(array('a', 'b')));
        $this->assertNotSame($hasher->hashArray(array('a', 'b')), $hasher->hashArray(array('b', 'a')));
    }

    public function testSetHashMethod()
    {
        $hasher = new Hasher();
        $this->assertEquals(new HashMethod(HashMethod::SHA1), $hasher->getHashMethod());

        $hashMethod = new HashMethod(HashMethod::SHA1);
        $hasher->setHashMethod($hashMethod);
        $this->assertSame($hashMethod, $hasher->getHashMethod());
    }
}
