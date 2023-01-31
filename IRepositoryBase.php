<?php

    /**
     * @template T
     * @param T $request
     * @return T
     */
interface IRepositoryBase
{

    
    function Create($request);
    function FindById($id);
    function FindAll();
    function Update(int $id,$request);
    function Delete(int $id);
}
