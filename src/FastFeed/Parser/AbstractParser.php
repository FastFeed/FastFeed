<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Parser;

use FastFeed\Exception\LogicException;
use FastFeed\Processor\AbstractProcessor;
use FastFeed\Processor\ProcessorInterface;

/**
 * AbstractParser
 */
abstract class AbstractParser extends AbstractProcessor
{

    /**
     * @var array
     */
    protected $processors = array();

    /**
     * @return mixed
     * @throws \FastFeed\Exception\LogicException
     */
    public function popProcessor()
    {
        if (!$this->processors) {
            throw new LogicException('You tried to pop from an empty processor stack.');
        }

        return array_shift($this->processors);
    }

    /**
     * @param ProcessorInterface $processor
     */
    public function pushProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }
} 