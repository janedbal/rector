<?php

namespace RectorPrefix20210729;

if (\class_exists('tx_rsaauth_split_storage')) {
    return;
}
class tx_rsaauth_split_storage
{
}
\class_alias('tx_rsaauth_split_storage', 'tx_rsaauth_split_storage', \false);
