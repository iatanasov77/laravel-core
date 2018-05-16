<?php namespace IA\Laravel\Core\Model\Interfaces;

interface SortAwareInterface
{
    public function moveAfter( $entity );

    public function moveBefore( $entity );
}
