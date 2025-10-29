<?php

use App\Models\Model_audit;

function audit_trail($action, $description = '')
{
    $auditModel = new Model_audit();
    $auditModel->insert([
        'id_user'     => session()->get('id_user'),
        'action'      => $action,
        'description' => $description,
        'ip_address'  => service('request')->getIPAddress(),
        'user_agent'  => service('request')->getUserAgent()->getAgentString(),
    ]);
}
