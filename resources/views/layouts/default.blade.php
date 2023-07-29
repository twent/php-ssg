<!DOCTYPE html>
<html lang="en-US">
@include('partials.head')
<body class="{{ $bodyClasses ?? '' }}">
<div class="intro intro-header font-sans">
    <div class="container mx-auto text-center pt-4">
        <a class="text-2xl text-red-500 inline-block" href="/">
            SSG
        </a>
    </div>
</div>
<div class="container mx-auto py-6 md:py-12 flex">
    <div class="mr-20 pt-2 flex-1 hidden md:block">
        <h3 class="text-xs uppercase font-semibold text-gray-500">
            Table of Contents
        </h3>
        <nav>
            <ul>
                @foreach($sections as $section)
                    <li>
                        <a class="text-base text-gray-700 block my-3 transition hover:text-pink-600"
                           href="#{{ $section->slug }}"
                        >
                            {{ $section->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <div style="flex: 4">
        <main class="px-6 md:px-0">
            <header class="width-100 border-b-2 mb-8 pb-4">
                <h1 class="text-3xl md:text-4xl font-thin text-gray-900 leading-snug">Welcome</h1>
                <h3 class="text-base md:text-lg text-gray-700">
                    A quick start guide for installing and using SSG. SSG with Blade & Vite.
                </h3>
            </header>
            @foreach($sections as $section)
                <section class="text-gray-700 leading-relaxed mb-12" id="{{ $section->slug }}">
                    <h2 class="block text-2xl font-semibold mb-2 text-gray-900">{{ $section->title }}</h2>
                    @foreach($section->contents as $content)
                        @if($content->type === 'code')
                            <div class="container bg-gray-800 rounded-none md:rounded-lg mx-auto my-6 py-6 px-6 md:px-12 shadow-xl">
                                <pre class="text-white whitespace-pre-wrap">{!! $content->text !!}</pre>
                            </div>
                        @else
                            <p class="my-6">{!! $content->text !!}</p>
                        @endif
                    @endforeach
                </section>
            @endforeach

            <div>
                <h2 class="block text-2xl font-semibold mb-2 text-gray-900">Shared data from data/example.json</h2>
                <ul>
                    @foreach($imports as $import)
                        <li>
                            <a href="{{ $import->url }}">{{ $import->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </main>
    </div>
</div>
@include('partials.footer')
</body>
</html>