<?php
namespace Concept\Collection;

use Closure;
use ArrayIterator;

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 */

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Collection
 * @name        AbstractCollection
 * @version     0.1
 */
class AbstractCollection implements CollectionInterface
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    protected $items;

    /**
     * Initializes a new Collection.
     *
     * @param array $items
     */
    public function __construct($items = array())
    {
        $this->items = $items;
    }

    /**
     * Adds an item at the end of the collection.
     *
     * @param mixed $item The item to add.
     * @return boolean Always TRUE.
     */
    public function add($item)
    {
        $this->items[] = $item;
        return true;
    }

    /**
     * Clears the collection, removing all items.
     */
    public function clear()
    {
        $this->items = array();
    }

    /**
     * Checks whether an item is contained in the collection.
     * This is an O(n) operation, where n is the size of the collection.
     *
     * @param mixed $item The item to search for.
     * @return boolean TRUE if the collection contains the item, FALSE otherwise.
     */
    public function contains($item)
    {
        return in_array($item, $this->items, true);
    }

    /**
     * Checks whether the collection is empty (contains no items).
     *
     * @return boolean TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty()
    {
        return ! $this->items;
    }

    /**
     * Removes the item at the specified index from the collection.
     *
     * @param string|integer $key The kex/index of the item to remove.
     * @return mixed The removed item or NULL, if the collection did not contain the item.
     */
    public function remove($key)
    {
        if ($this->containsKey($key)) {
            $removed = $this->items[$key];
            unset($this->items[$key]);

            return $removed;
        }

        return null;
    }

    /**
     * Removes the specified item from the collection, if it is found.
     *
     * @param mixed $item The item to remove.
     * @return boolean TRUE if this collection contained the specified item, FALSE otherwise.
     */
    public function removeElement($item)
    {
        $key = array_search($item, $this->items, true);

        if ($key !== false) {
            unset($this->items[$key]);

            return true;
        }

        return false;
    }

    /**
     * Checks whether the collection contains an item with the specified key/index.
     *
     * @param string|integer $key The key/index to check for.
     * @return boolean TRUE if the collection contains an item with the specified key/index,
     *                            FALSE otherwise.
     */
    public function containsKey($key)
    {
        return isset($this->items[$key]) || array_key_exists($key, $this->items);
    }

    /**
     * Gets the item at the specified key/index.
     *
     * @param string|integer $key The key/index of the item to retrieve.
     * @return mixed
     */
    public function get($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
        return null;
    }

    /**
     * Gets all keys/indices of the collection.
     *
     * @return array The keys/indices of the collection, in the order of the corresponding
     *          items in the collection.
     */
    public function getKeys()
    {
        return array_keys($this->items);
    }

    /**
     * Gets all values of the collection.
     *
     * @return array The values of all items in the collection, in the order they
     *          appear in the collection.
     */
    public function getValues()
    {
        return array_values($this->items);
    }

    /**
     * Sets an item in the collection at the specified key/index.
     *
     * @param string|integer $key   The key/index of the item to set.
     * @param mixed          $value The item to set.
     * @return boolean
     */
    public function set($key, $value)
    {
        $this->items[$key] = $value;
        return true;
    }

    /**
     * Gets a native PHP array representation of the collection.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Sets the internal iterator to the first item in the collection and
     * returns this item.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * Sets the internal iterator to the last item in the collection and
     * returns this item.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * Gets the key/index of the item at the current iterator position.
     *
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * Gets the item of the collection at the current iterator position.
     *
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Moves the internal iterator position to the next item.
     *
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * Tests for the existence of an item that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE if the predicate is TRUE for at least one item, FALSE otherwise.
     */
    public function exists(Closure $p)
    {
        // TODO: Implement exists() method.
    }

    /**
     * Returns all the items of this collection that satisfy the predicate p.
     * The order of the items is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function filter(Closure $p)
    {
        // TODO: Implement filter() method.
    }

    /**
     * Applies the given predicate p to all items of this collection,
     * returning true, if the predicate yields true for all items.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE, if the predicate yields TRUE for all items, FALSE otherwise.
     */
    public function forAll(Closure $p)
    {
        // TODO: Implement forAll() method.
    }

    /**
     * Applies the given public function to each item in the collection and returns
     * a new collection with the items returned by the public function.
     *
     * @param Closure $func
     * @return CollectionInterface
     */
    public function map(Closure $func)
    {
        // TODO: Implement map() method.
    }

    /**
     * Partitions this collection in two collections according to a predicate.
     * Keys are preserved in the resulting collections.
     *
     * @param Closure $p The predicate on which to partition.
     * @return array An array with two items. The first item contains the collection
     *                   of items where the predicate returned TRUE, the second item
     *                   contains the collection of items where the predicate returned FALSE.
     */
    public function partition(Closure $p)
    {
        // TODO: Implement partition() method.
    }

    /**
     * Gets the index/key of a given item. The comparison of two items is strict,
     * that means not only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $item The item to search for.
     * @return mixed The key/index of the item or FALSE if the item was not found.
     */
    public function indexOf($item)
    {
        return array_search($item, $this->items, true);
    }

    /**
     * Extract a slice of $length items starting at position $offset from the Collection.
     *
     * If $length is null it returns all items from $offset to the end of the Collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the items contained in the collection slice is called on.
     *
     * @param int $offset
     * @param int $length
     * @return array
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->items, $offset, $length, true);
    }

    /**
     * Gets an iterator for iterating over the elements in the collection.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * ArrayAccess implementation of offsetExists()
     *
     * @see containsKey()
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @see get()
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @see add()
     * @see set()
     */
    public function offsetSet($offset, $value)
    {
        if ( ! isset($offset)) {
            return $this->add($value);
        }
        return $this->set($offset, $value);
    }

    /**
     * ArrayAccess implementation of offsetUnset()
     *
     * @see remove()
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * Returns the number of items in the collection.
     *
     * Implementation of the Countable interface.
     *
     * @return integer The number of items in the collection.
     */
    public function count()
    {
        return count($this->items);
    }
}
