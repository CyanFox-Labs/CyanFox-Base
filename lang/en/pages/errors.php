<?php

return [
    'your_client' => 'Your Client',
    'network' => 'Network',
    'web_server' => 'Web Server',
    'working' => 'Working',
    'unknown' => 'Unknown',
    'what_happened' => 'What happened?',
    'what_can_i_do' => 'What can I do?',

    'codes' => [
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '407' => 'Proxy Authentication Required',
        '408' => 'Request Timeout',
        '409' => 'Conflict',
        '410' => 'Gone',
        '411' => 'Length Required',
        '412' => 'Precondition Failed',
        '413' => 'Payload Too Large',
        '416' => 'Range Not Satisfiable',
        '418' => 'I\'m a teapot',
        '429' => 'Too Many Requests',
        '500' => 'Internal Server Error',
        '502' => 'Bad Gateway',
        '503' => 'Service Unavailable',
        '504' => 'Gateway Timeout',
        '505' => 'HTTP Version Not Supported',
    ],

    'what_happened_descriptions' => [
        '400' => 'The server did not understand the request.',
        '401' => 'You are not authorized to access this page.',
        '403' => 'You are not authorized to access this page.',
        '404' => 'The server cannot find the requested page.',
        '405' => 'The method specified in the request is not allowed.',
        '407' => 'You must authenticate with a proxy server before this request can be served.',
        '408' => 'The request took longer than the server was prepared to wait.',
        '409' => 'The request could not be completed because of a conflict.',
        '410' => 'The requested page is no longer available.',
        '411' => 'The "Content-Length" is not defined. The server will not accept the request without it.',
        '412' => 'The precondition given in the request evaluated to false by the server.',
        '413' => 'The server will not accept the request, because the request entity is too large.',
        '416' => 'The requested byte range is not available and is out of bounds.',
        '418' => 'I\'m a teapot.',
        '429' => 'Too many requests in a given amount of time.',
        '500' => 'The server met an unexpected condition.',
        '502' => 'The server received an invalid response from the upstream server.',
        '503' => 'The server is temporarily overloading or down',
        '504' => 'The gateway has timed out.',
        '505' => 'The server does not support the "http protocol" version.',
    ],

    'what_can_i_do_descriptions' => [
        'try_again_later' => 'Please try again later or click <a href=":here">here</a> to be redirected to the homepage.',
        'nothing_you_can_do' => '¯\\_(ツ)_/¯',
        'change_request' => 'Please try to change the request method, headers, payload, or URL and try again. Click <a href=":here">here</a> to be redirected to the homepage.',
        'mistake' => 'If you think this is a mistake, please contact the website administrator. Click <a href=":here">here</a> to be redirected to the homepage.',
        '404' => 'Please check the URL or click <a href=":here">here</a> to be redirected to the homepage.',
        '429' => 'You have made too many requests. Please try again later or click <a href=":here">here</a> to be redirected to the homepage.',
    ],
];