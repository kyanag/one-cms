<?php


namespace App\Admin\Grid\Interfaces;


interface OptionProviderInterface
{

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return iterable
     */
    public function toIterator();
}