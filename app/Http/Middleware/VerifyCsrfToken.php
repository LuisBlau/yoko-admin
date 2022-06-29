<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/apis/collection',
        '/v2/users/collector',
        '/aabo/collector',
        '/messages',
        '/peerless/messages',
        '/gptransco/tenstreet',
        '/readagentsinqueue',
        '/makeacall',
        '/makeacalltopbx',
        '/cronjob/pull/netsapiensdomains',
        '/cronjob/pull/netsapiensdomainsummary',
        '/cronjob/pull/netsapienscollectextensions',
        '/cronjob/pull/netsapiensdomainextensionwithsms',
        '/cronjob/countdailybillingnumbers',
        '/gptransco/tenstreetlog',
    ];
}