<?php namespace IA\Laravel\Core\Model\Interfaces;

interface MetadataAwareInterface
{
    public function getAllMeta();

    public function getMeta( $key, $default = null, $getObj = false );

    public function updateMeta( $key, $newValue, $oldValue = false );

    public function addMeta( $key, $value );

    public function appendMeta( $key, $value );

    public function deleteMeta( $key, $value = false );

    public function deleteAllMeta();
}
