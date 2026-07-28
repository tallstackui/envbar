<?php

use Illuminate\Support\Facades\Route;
use TallStackUi\EnvBar\Middleware\Injection;

arch('should have all needed methods')
    ->expect(Injection::class)
    ->toHaveMethods(['handle']);

beforeEach(function () {
    Route::middleware('web')->group(function (): void {
        Route::get('/html', fn () => '<html><head></head><body><p>content</p></body></html>');
        Route::get('/placeholder', fn () => '<html><head></head><body><div>@envbar</div></body></html>');
        Route::get('/attributes', fn () => '<html><head lang="pt-BR" data-x="a>b"><title>t</title></head><body class="a>b"><p>c</p></body></html>');
        Route::get('/fragment', fn () => '<p>no document tags at all</p>');
        Route::get('/json', fn () => response()->json(['message' => '@envbar']));
        Route::get('/text', fn () => response('@envbar', 200, ['Content-Type' => 'text/plain']));
    });
});

it('injects the assets and the component on html responses', function () {
    expect($this->get('/html')->getContent())
        ->toContain('data-source="envbar-css"')
        ->toContain('data-source="envbar-js"')
        ->toContain('id="envbar"');
});

it('injects the css before the js', function () {
    $content = $this->get('/html')->getContent();

    expect(strpos($content, 'data-source="envbar-css"'))
        ->toBeLessThan(strpos($content, 'data-source="envbar-js"'));
});

it('replaces the placeholder instead of injecting after the body', function () {
    $content = $this->get('/placeholder')->getContent();

    expect($content)->not->toContain('<div>@envbar</div>')
        ->and(substr_count($content, 'id="envbar"'))->toBe(1);
});

it('injects on head and body tags carrying attributes', function () {
    expect($this->get('/attributes')->getContent())
        ->toContain('data-source="envbar-css"')
        ->toContain('id="envbar"');
});

it('leaves a response without document tags untouched', function () {
    expect($this->get('/fragment')->getContent())->toBe('<p>no document tags at all</p>');
});

it('does not touch json responses', function () {
    expect($this->get('/json')->getContent())->toBe('{"message":"@envbar"}');
});

it('does not touch plain text responses', function () {
    expect($this->get('/text')->getContent())->toBe('@envbar');
});

it('does not inject on unsuccessful responses', function () {
    expect($this->get('/missing')->assertNotFound()->getContent())->not->toContain('id="envbar"');
});
