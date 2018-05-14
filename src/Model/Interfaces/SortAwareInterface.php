<?php namespace IA\LaravelCore\Model\Interfaces;

interface SortAwareInterface
{
    public function moveAfter( $entity );

    public function moveBefore( $entity );
}
