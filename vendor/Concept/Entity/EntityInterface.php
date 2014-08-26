<?php
namespace Concept\Entity;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Entity\Manager
 * @name        EntityInterface
 * @version     0.1
 */
interface EntityInterface
{
    /**
     * @return array
     */
    public function convertArray();

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param  mixed $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents();

    /**
     * @param array $data
     */
    public function bind($data);
}
