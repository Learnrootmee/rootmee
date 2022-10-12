<?php

namespace Staatic\Vendor\AsyncAws\Core\Signer;

use Staatic\Vendor\AsyncAws\Core\Credentials\Credentials;
use Staatic\Vendor\AsyncAws\Core\Request;
use Staatic\Vendor\AsyncAws\Core\RequestContext;
interface Signer
{
    /**
     * @param Request $request
     * @param Credentials $credentials
     * @param RequestContext $context
     * @return void
     */
    public function sign($request, $credentials, $context);
    /**
     * @param Request $request
     * @param Credentials $credentials
     * @param RequestContext $context
     * @return void
     */
    public function presign($request, $credentials, $context);
}
