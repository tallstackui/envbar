<div class="sticky top-0 z-50">
    <x-dynamic-component :component="TallStackUi::component('alert')" scope="envbar">
        You are in the
        <x-dynamic-component :component="TallStackUi::component('badge')">
            Local
        </x-dynamic-component>
        environment
        <x-dynamic-component :component="TallStackUi::component('badge')" color="red">
            Local
        </x-dynamic-component>
        <x-dynamic-component :component="TallStackUi::component('badge')" color="red">
            The current release is master
        </x-dynamic-component>
    </x-dynamic-component>
</div>
