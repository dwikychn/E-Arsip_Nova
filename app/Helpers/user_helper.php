<?php

function getNamaUser($id)
{
    return db_connect()->table('user')->where('id_user', $id)->get()->getRow('nama_user');
}