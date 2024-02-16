<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        code {
            font-family: monospace, monospace;
            font-size: 1em
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *, :after, :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        code {
            font-family: Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace
        }

        svg, video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .flex {
            display: flex
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .text-lg {
            font-size: 1.125rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .max-w-xl {
            max-width: 36rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .pt-8 {
            padding-top: 2rem
        }

        .relative {
            position: relative
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .uppercase {
            text-transform: uppercase
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .tracking-wider {
            letter-spacing: .05em
        }

        @-webkit-keyframes spin {
            0% {
                transform: rotate(0deg)
            }
            to {
                transform: rotate(1turn)
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }
            to {
                transform: rotate(1turn)
            }
        }

        @-webkit-keyframes ping {
            0% {
                transform: scale(1);
                opacity: 1
            }
            75%, to {
                transform: scale(2);
                opacity: 0
            }
        }

        @keyframes ping {
            0% {
                transform: scale(1);
                opacity: 1
            }
            75%, to {
                transform: scale(2);
                opacity: 0
            }
        }

        @-webkit-keyframes pulse {
            0%, to {
                opacity: 1
            }
            50% {
                opacity: .5
            }
        }

        @keyframes pulse {
            0%, to {
                opacity: 1
            }
            50% {
                opacity: .5
            }
        }

        @-webkit-keyframes bounce {
            0%, to {
                transform: translateY(-25%);
                -webkit-animation-timing-function: cubic-bezier(.8, 0, 1, 1);
                animation-timing-function: cubic-bezier(.8, 0, 1, 1)
            }
            50% {
                transform: translateY(0);
                -webkit-animation-timing-function: cubic-bezier(0, 0, .2, 1);
                animation-timing-function: cubic-bezier(0, 0, .2, 1)
            }
        }

        @keyframes bounce {
            0%, to {
                transform: translateY(-25%);
                -webkit-animation-timing-function: cubic-bezier(.8, 0, 1, 1);
                animation-timing-function: cubic-bezier(.8, 0, 1, 1)
            }
            50% {
                transform: translateY(0);
                -webkit-animation-timing-function: cubic-bezier(0, 0, .2, 1);
                animation-timing-function: cubic-bezier(0, 0, .2, 1)
            }
        }

        @media (min-width: 640px) {

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }
        }

        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }
        }
    </style>

    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center pt-8 text-lg text-gray-500 uppercase tracking-wider sm:justify-start sm:pt-0">
            <div id="error_text">
                <span class="source">@yield('code'): <span data-l10n>@yield('message')</span></span>
                <span class="target"></span>
            </div>
        </div>
    </div>
</div>


<script>
    'use strict';

    /*

    Shuffle text by https://github.com/tarampampam/error-pages

    */


    /**
     * @param {HTMLElement} $el
     */
    const Shuffle = function ($el) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=+<>,./?[{()}]!@#$%^&*~`\|'.split(''),
            $source = $el.querySelector('.source'), $target = $el.querySelector('.target');

        let cursor = 0, scrambleInterval = undefined, cursorDelayInterval = undefined, cursorInterval = undefined;

        /**
         * @param {Number} len
         * @return {string}
         */
        const getRandomizedString = function (len) {
            let s = '';

            for (let i = 0; i < len; i++) {
                s += chars[Math.floor(Math.random() * chars.length)];
            }

            return s;
        };

        this.start = function () {
            $source.style.display = 'none';
            $target.style.display = 'block';

            scrambleInterval = window.setInterval(() => {
                if (cursor <= $source.innerText.length) {
                    $target.innerText = $source.innerText.substring(0, cursor) + getRandomizedString($source.innerText.length - cursor);
                }
            }, 450 / 30);

            cursorDelayInterval = window.setTimeout(() => {
                cursorInterval = window.setInterval(() => {
                    if (cursor > $source.innerText.length - 1) {
                        this.stop();
                    }

                    cursor++;
                }, 30);
            }, 350);
        };

        this.stop = function () {
            $source.style.display = 'block';
            $target.style.display = 'none';
            $target.innerText = '';
            cursor = 0;

            if (scrambleInterval !== undefined) {
                window.clearInterval(scrambleInterval);
                scrambleInterval = undefined;
            }

            if (cursorInterval !== undefined) {
                window.clearInterval(cursorInterval);
                cursorInterval = undefined;
            }

            if (cursorDelayInterval !== undefined) {
                window.clearInterval(cursorDelayInterval);
                cursorDelayInterval = undefined;
            }
        };
    };

    (new Shuffle(document.getElementById('error_text'))).start();
</script>
</body>
</html>
