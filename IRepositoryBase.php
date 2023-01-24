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
     /**
     * @template T
     * @param T $request
     * @return T
     */
    function Update($request);
    function Delete($request);
}
