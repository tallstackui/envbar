<div @class([
        'py-3 px-4 text-base flex items-center',
        'border-l-6 border-blue-500 bg-blue-100 text-blue-700',
//        'border-l-6 border-purple-500 bg-purple-100 text-purple-700' => $envColor === 'purple',
//        'border-l-6 border-green-500 bg-green-100 text-green-700' => $envColor === 'green',
//        'border-l-6 border-red-500 bg-red-100 text-red-700' => $envColor === 'red',
//        'border-l-6 border-yellow-500 bg-yellow-100 text-yellow-700' => $envColor === 'yellow',
//        'border-l-6 border-amber-500 bg-amber-100 text-amber-700' => $envColor === 'amber',
//        'border-l-6 border-orange-500 bg-orange-100 text-orange-700' => $envColor === 'orange',
//        'border-l-6 border-indigo-500 bg-indigo-100 text-indigo-700' => $envColor === 'indigo',
//        'border-l-6 border-gray-500 bg-gray-300 text-gray-800' => $envColor === 'gray'
    ]) role="envbar-alert">
    You are in the
    @lang('envbar::messages.you-are-in-the')
    <span>
        Local
    </span>
    environment
    <span>
        feat/foo-bar
    </span>
    <span>
        The current release is master
    </span>
</div>
