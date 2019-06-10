@extends('_layouts.master')

@section('body')
<section class="container max-w-2xl mx-auto px-6 py-10 md:py-12">
    <div class="flex flex-col-reverse mb-10 lg:flex-row lg:mb-24">
        <div class="mt-8">
            <h1 id="intro-docs-template">{{ $page->siteName }}</h1>

            <h2 id="intro-powered-by-jigsaw" class="font-light mt-4">{{ $page->siteDescription }}</h2>

            <p class="text-lg">Back-sql provides an interface for storing LDAP information using SQL against SQL databases, namely MySQL and Postgres.
                 <br class="hidden sm:block">The goal of this auxiliary documentation is to provide an entry point for exploring using OpenLDAP.
            <br class="hidden sm:block">The use of an SQL database could be for either easier back up, clearer design or integration of existing authentication system. Or none of the above.</p>

            <div class="flex my-10">
                <a href="/docs/getting-started" title="{{ $page->siteName }} getting started" class="bg-blue hover:bg-blue-dark font-normal text-white hover:text-white rounded mr-4 py-2 px-6">Get Started</a>

                <a href="/notes/notes-general" title="Implementation Notes" class="bg-grey-light hover:bg-grey-dark text-blue-darkest font-normal hover:text-white rounded py-2 px-6">Notes</a>
            </div>
        </div>

        <img src="/assets/img/logo-large.svg" alt="{{ $page->siteName }} large logo" class="mx-auto mb-6 lg:mb-0 ">
    </div>

    <hr class="block my-8 border lg:hidden">

    <div class="md:flex -mx-2 -mx-4">
        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-window.svg" class="h-12 w-12" alt="window icon">

            <h3 id="intro-laravel" class="text-2xl text-blue-darkest mb-0">Use existing data <br>to provide LDAP information</h3>

            <p>back-sql provides an interface for LDAP for DBAs</p>
        </div>

        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-terminal.svg" class="h-12 w-12" alt="terminal icon">

            <h3 id="intro-markdown" class="text-2xl text-blue-darkest mb-0">Reuse passwords <br>for custom build SSO</h3>

            <p>Passwords can be reused without breaking the hash.</p>
        </div>

        <div class="mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-stack.svg" class="h-12 w-12" alt="stack icon">

            <h3 id="intro-mix" class="text-2xl text-blue-darkest mb-0">One more <br>thing</h3>

            <p></p>
        </div>
    </div>
</section>
@endsection
