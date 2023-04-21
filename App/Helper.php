<?php

use App\Models\Movie;

if (! function_exists('toggleActiveMenu')) {
    function toggleActiveMenu($path): string
    {
        return request()->url === '/'.$path ? 'class="active"' : '';
    }
}

if (! function_exists('showFirstError')) {
    function showFirstError()
    {
        $errors = session()->get('errors');
        if (! empty($errors)) {
            return $errors[0];
        }

        return null;
    }
}

if (! function_exists('alertError')) {
    function alertError(): string
    {
        $errors = session()->get('errors');
        if (! empty($errors)) {
            return "
                swal({
                    title: 'Error !',
                    text: '$errors[0]',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-warning',
                    type: 'warning'
                })
            ";
        }

        return '';
    }
}


if (! function_exists('alertSuccess')) {
    function alertSuccess(): string
    {
        $success = session()->get('success');
        if (! empty($success)) {
            return "
                swal({
                    title: 'Successfully !',
                    text: '$success',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-success',
                    type: 'success'
                })
            ";
        }

        return '';
    }
}

if (! function_exists('showSuccess')) {
    function showSuccess()
    {
        return session()->get('success');
    }
}

if (! function_exists('authed')) {
    function authed()
    {
        return session()->get('auth');
    }
}

if (! function_exists('redirectBackWithError')) {
    function redirectBackWithError(string $error)
    {
        session()->flash('errors', [$error]);

        redirect()->back();
    }
}

if (! function_exists('redirectBackWithSuccess')) {
    function redirectBackWithSuccess(string $message)
    {
        session()->flash('success', $message);

        redirect()->back();
    }
}

if (! function_exists('redirectWithSuccess')) {
    function redirectWithSuccess(string $route, string $message)
    {
        session()->flash('success', $message);

        redirect()->route($route);
    }
}

if (! function_exists('prettyMoney')) {
    function prettyMoney($money): string
    {
        return number_format($money, 0, '', ',');
    }
}

if (! function_exists('getMovieFeed')) {
    function getMovieFeed(): array
    {
        return (new Movie)->limit(8)->get(['banner']);
    }
}
