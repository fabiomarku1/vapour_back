<?php

interface IRepositoryBase{

    function Create($request);
    function FindById($id);
    function FindAll();
    function Update($request);
    function Delete($request);

}

