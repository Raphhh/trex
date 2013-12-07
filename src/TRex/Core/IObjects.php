<?php
namespace TRex\Core;

use TRex\Iterator\IIterator;
use TRex\Iterator\IKeyAccessor;

interface IObjects extends IIterator, \IteratorAggregate, \ArrayAccess, IKeyAccessor, \Countable
{

}
