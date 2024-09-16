<?php

use TallStackUi\EnvBar\View\Components\BaseComponent;

arch('should be abstract')
    ->expect(BaseComponent::class)
    ->toBeAbstract();
