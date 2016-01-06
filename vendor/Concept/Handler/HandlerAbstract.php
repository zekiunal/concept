<?php
namespace Concept\Handler;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Handler
 * @name        HandlerAbstract
 * @version     0.1
 */
abstract class HandlerAbstract
{
    /**
     * @var HandlerInterface
     */
    protected $successor;

    /**
     * @param HandlerInterface $nextService
     */
    public function setSuccessor(HandlerInterface $nextService)
    {
        $this->successor = $nextService;
    }
}
