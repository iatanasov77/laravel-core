<?php namespace IA\Laravel\Core\Model\Interfaces;

interface ActivatableAwareInterface
{

    public function activate();

    public function deactivate();
}
