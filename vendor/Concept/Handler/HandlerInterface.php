<?php
namespace Concept\Handler;

use Concept\Entity\EntityInterface;
use Concept\Filter\FilterInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Handler
 * @name        HandlerInterface
 * @version     0.1
 */
interface HandlerInterface
{
    /**
     * @param HandlerInterface $nextService
     */
    public function setSuccessor(HandlerInterface $nextService);
}
