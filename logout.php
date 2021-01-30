<?php
    session_name("my-dynamic-cv");
    session_start();

    session_unset();
    session_destroy();

    header("Location: ./");