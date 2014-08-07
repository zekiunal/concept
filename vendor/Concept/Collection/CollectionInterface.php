<?php
namespace Concept\Collection;

use Countable;
use IteratorAggregate;
use ArrayAccess;
use Closure;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Entity\Manager
 * @name        CollectionInterface
 * @version     0.1
 */
interface CollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * Adds an item at the end of the collection.
     *
     * @param mixed $item The item to add.
     * @return boolean Always TRUE.
     */
    public function add($item);

    /**
     * Clears the collection, removing all items.
     */
    public function clear();

    /**
     * Checks whether an item is contained in the collection.
     * This is an O(n) operation, where n is the size of the collection.
     *
     * @param mixed $item The item to search for.
     * @return boolean TRUE if the collection contains the item, FALSE otherwise.
     */
    public function contains($item);

    /**
     * Checks whether the collection is empty (contains no items).
     *
     * @return boolean TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty();

    /**
     * Removes the item at the specified index from the collection.
     *
     * @param string|integer $key The kex/index of the item to remove.
     * @return mixed The removed item or NULL, if the collection did not contain the item.
     */
    public function remove($key);

    /**
     * Removes the specified item from the collection, if it is found.
     *
     * @param mixed $item The item to remove.
     * @return boolean TRUE if this collection contained the specified item, FALSE otherwise.
     */
    public function removeElement($item);

    /**
     * Checks whether the collection contains an item with the specified key/index.
     *
     * @param string|integer $key The key/index to check for.
     * @return boolean TRUE if the collection contains an item with the specified key/index,
     *          FALSE otherwise.
     */
    public function containsKey($key);

    /**
     * Gets the item at the specified key/index.
     *
     * @param string|integer $key The key/index of the item to retrieve.
     * @return mixed
     */
    public function get($key);

    /**
     * Gets all keys/indices of the collection.
     *
     * @return array The keys/indices of the collection, in the order of the corresponding
     *          items in the collection.
     */
    public function getKeys();

    /**
     * Gets all values of the collection.
     *
     * @return array The values of all items in the collection, in the order they
     *          appear in the collection.
     */
    public function getValues();

    /**
     * Sets an item in the collection at the specified key/index.
     *
     * @param string|integer $key The key/index of the item to set.
     * @param mixed $value The item to set.
     */
    public function set($key, $value);

    /**
     * Gets a native PHP array representation of the collection.
     *
     * @return array
     */
    public function toArray();

    /**
     * Sets the internal iterator to the first item in the collection and
     * returns this item.
     *
     * @return mixed
     */
    public function first();

    /**
     * Sets the internal iterator to the last item in the collection and
     * returns this item.
     *
     * @return mixed
     */
    public function last();

    /**
     * Gets the key/index of the item at the current iterator position.
     *
     */
    public function key();

    /**
     * Gets the item of the collection at the current iterator position.
     *
     */
    public function current();

    /**
     * Moves the internal iterator position to the next item.
     *
     */
    public function next();

    /**
     * Tests for the existence of an item that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE if the predicate is TRUE for at least one item, FALSE otherwise.
     */
    public function exists(Closure $p);

    /**
     * Returns all the items of this collection that satisfy the predicate p.
     * The order of the items is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     * @return CollectionInterface A collection with the results of the filter operation.
     */
    public function filter(Closure $p);

    /**
     * Applies the given predicate p to all items of this collection,
     * returning true, if the predicate yields true for all items.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE, if the predicate yields TRUE for all items, FALSE otherwise.
     */
    public function forAll(Closure $p);

    /**
     * Applies the given public function to each item in the collection and returns
     * a new collection with the items returned by the public function.
     *
     * @param Closure $func
     * @return CollectionInterface
     */
    public function map(Closure $func);

    /**
     * Partitions this collection in two collections according to a predicate.
     * Keys are preserved in the resulting collections.
     *
     * @param Closure $p The predicate on which to partition.
     * @return array An array with two items. The first item contains the collection
     *               of items where the predicate returned TRUE, the second item
     *               contains the collection of items where the predicate returned FALSE.
     */
    public function partition(Closure $p);

    /**
     * Gets the index/key of a given item. The comparison of two items is strict,
     * that means not only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $item The item to search for.
     * @return mixed The key/index of the item or FALSE if the item was not found.
     */
    public function indexOf($item);

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
    public function slice($offset, $length = null);
}
