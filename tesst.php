<?php

echo shell_exec('while (1) { ps | sort -desc cpu | select -first 30; sleep -seconds 2; cls }');



//print_r(win32_ps_stat_proc());
/*
    Array
    (
        [pid] => 936
        [exe] => C:\Program Files\PHP7\php.exe
        [mem] => Array
            (
                [page_fault_count] => 2062
                [peak_working_set_size] => 8396800
                [working_set_size] => 8396800
                [quota_peak_paged_pool_usage] => 32080
                [quota_paged_pool_usage] => 31876
                [quota_peak_non_paged_pool_usage] => 4240
                [quota_non_paged_pool_usage] => 3888
                [pagefile_usage] => 5865472
                [peak_pagefile_usage] => 5865472
            )

        [tms] => Array
            (
                [created] => 0.093
                [kernel] => 0.015
                [user] => 0.062
            )

    )
*/
?>