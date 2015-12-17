<?php
namespace fly\interfaces;

interface DbFactorInterface
{

    public function changeFactory($factor);

    public function getDbName();

    public function getTableName();
}