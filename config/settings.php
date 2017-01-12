<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Text Settings
    |--------------------------------------------------------------------------
    */

    'user' => [
        /*
        |--------------------------------------------------------------------------
        | User Image Policy
        |--------------------------------------------------------------------------
        |
        | If you fill in this text string, a box will appear near any prompt for a
        | user to upload their photo. It's a good place for a reminder about any
        | rules you may have regarding content rules, privacy, or security.
        |
        */
        'user_image_policy' => '',

        /*
        |--------------------------------------------------------------------------
        | User Image Resize
        |--------------------------------------------------------------------------
        |
        | Here you can customize the pixel value that will be used when resizing
        | profile images.
        |
        */
        'user_image_resize' => 250,

        /*
        |--------------------------------------------------------------------------
        | User Archive Limit (in Days)
        |--------------------------------------------------------------------------
        |
        | Here, you can customize the number of days that you wish to keep the
        | records of deleted student accounts. At the end of this interval,
        | any student accounts in the trash, and their data will be moved 
        | out of the system for cold storage.
        |
        */
        'user_archive_limit' => 30,    
    ],


];
