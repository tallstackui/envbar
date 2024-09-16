<?php

use TallStackUi\EnvBar\Providers\AbstractProvider;
use TallStackUi\EnvBar\Providers\BitBucketProvider;

arch('should have all needed methods')
    ->expect(BitBucketProvider::class)
    ->toHaveMethods(['fetch', 'provider']);

arch('should extend AbstractProvider')
    ->expect(BitBucketProvider::class)
    ->toExtend(AbstractProvider::class);
