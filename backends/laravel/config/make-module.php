<?php
return ['mode'=>env('MODULE_MAKER_MODE','multitenant'),'primary_key'=>env('MODULE_MAKER_PRIMARY_KEY','ulid'),'tenancy'=>['package'=>env('MODULE_MAKER_TENANCY_PACKAGE','stancl')]];
