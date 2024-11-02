<?php

interface DaoInterface {
    public function create($object);
    public function read($id);
    public function update($object);
    public function delete($id);
    public function readAll();
}

