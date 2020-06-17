<?php
declare (strict_types = 1);
namespace test;

use lyz7805\think\library\traits\controller\Jump;

class Index
{
    use Jump;

    public function index()
    {
        $this->success('success', 'index/index');
    }
}