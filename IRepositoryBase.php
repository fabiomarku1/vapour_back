<?php
interface IRepositoryBase
{
    function Create($request);
    function FindById($id);
    function FindAll();
    function Update(int $id,$request);
    function Delete(int $id);
}
