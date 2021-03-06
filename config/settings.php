<?php

return [

    'course' => [
        /*
        | Course Levels
        |--------------------------------------------------------------------------
        | Set the levels you wish to use for organizing courses. Leave the array empty
        | to disregard coures levels. Use a level marked '000' to designate courses
        | not assigned to a level in an LMS environment where other courses are.
        */
        'levels' => [
            1 => '100', 2 => '200', 3 => '300', 4 => '400', 5 => '500', 6 => '600'
        ],

    ],
    'user' => [
        /*
        | User Image Policy
        |--------------------------------------------------------------------------
        | If you fill in this string, the text will appear near any prompt for users
        | to upload their photo - great for reminders re: content, privacy, or security.
        */
        'user_image_policy' => '',

        /*
        | User Image Resize
        |--------------------------------------------------------------------------
        | Here you can customize the pixel value \used when resizing profile images.
        */
        'user_image_resize' => 250,

        /*
        | User Archive Limit (in Days)
        |--------------------------------------------------------------------------
        | Sets the number of days that you wish to keep the records of deleted student 
        | accounts. At the end of this interval, any student accounts in the trash, 
        | and their data will be zipped and archived. Mark as -1 to keep indefinitely.
        */
        'user_archive_limit' => 30,    
    ],

    'post' => [
        /*
        | User Image Resize
        |--------------------------------------------------------------------------
        | Here you can customize the pixel value \used when resizing profile images.
        */
        'post_image_resize' => 600, 
    ],

];
