<!DOCTYPE HTML>
<!--
	Dopetrope by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
@php
    if (!isset($page_title)){ $page_title=''; }
@endphp
<html>
	<head>
        @if ( isset($page_title))
            <title>{{ $page_title }}</title>
        @else
            <title>Quiz Tournement</title>
        @endif
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="{{URL::asset('resources/css/main.min.css')}}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

        @yield('head')
	</head>
	<body class="no-sidebar is-preload">
		<div id="page-wrapper">
            <section id="header">
                <h1><a href="/">Quiz Tournement</a></h1>
            </section>
            <section id="main">
                <div class="container">
                    @yield('content')
                </div>
            </section>
            <section id="footer">
                <div class="container">
                    <!-- <a>Logout</a> -->
                </div>
            </section>
		</div>
        @yield('script')
	</body>
</html>
