@extends('errors::minimal')

@section('title', $exception->getMessage() ?: __('errors.unknown'))
@section('code', $exception->getStatusCode())
@section('message', $exception->getMessage() ?: __('errors.unknown'))
