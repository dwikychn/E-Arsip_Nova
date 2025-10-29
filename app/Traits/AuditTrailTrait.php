<?php

namespace App\Traits;

use App\Models\Model_audit;

trait AuditTrailTrait
{
    public function logAudit($action, $description = '')
    {
        $username = session()->get('username');
        $id_user  = session()->get('id_user');
        log_message('debug', 'AUDIT DEBUG -> id_user: ' . $id_user . ', username: ' . $username);
        $auditModel = new Model_audit();
        $auditModel->insert([
            'id_user'     => session()->get('id_user'),
            'username'    => session()->get('username'),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => service('request')->getIPAddress(),
            'user_agent'  => service('request')->getUserAgent()->getAgentString(),
        ]);
    }
}
