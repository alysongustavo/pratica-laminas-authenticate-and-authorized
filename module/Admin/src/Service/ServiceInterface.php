<?php


namespace Admin\Service;


interface ServiceInterface
{
    function find($id);
    function findAll();
    function save($entity);
    function update($entity, $id);
    function destroy($id);

}