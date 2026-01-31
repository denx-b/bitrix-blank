<?php

namespace Legacy\Api\Methods\Deploy;

use Legacy\Api\Api;

class GitStatus extends Api
{
    public function init()
    {
        // Простейшая защита для GitHub
        $token = (string)$this->request->get('token');

        if ($token !== 'your-token') {
            $this->setFields([
                'success' => false,
                'status' => 'forbidden',
                'code'   => 403,
                'error'  => 'forbidden'
            ]);
            return;
        }

        $projectRoot = (string)$this->server->getDocumentRoot();
        if ($projectRoot === '' || !is_dir($projectRoot)) {
            $this->setFields([
                'success' => false,
                'status' => 'error',
                'code'   => 2,
                'error'  => 'invalid document root'
            ]);
            return;
        }

        $gitDir = $projectRoot . '/.git';
        if (!is_dir($gitDir) && !is_file($gitDir)) {
            $this->setFields([
                'success' => false,
                'status' => 'error',
                'code'   => 2,
                'error'  => 'git repository not found'
            ]);
            return;
        }

        $cmd = 'cd ' . escapeshellarg($projectRoot) . ' && git status --porcelain 2>&1';

        $output = [];
        $exitCode = 0;

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            $this->setFields([
                'success' => false,
                'status' => 'error',
                'code'   => 2,
                'error'  => 'git command failed',
                'details' => $output
            ]);
            return;
        }

        if (empty($output)) {
            $this->setFields([
                'status' => 'clean',
                'code'   => 0
            ]);
        } else {
            $this->setFields([
                'status' => 'dirty',
                'code'   => 1,
                'files'  => $output
            ]);
        }
    }
}
