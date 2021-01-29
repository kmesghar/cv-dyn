<?php
    session_name("my-dynamic-cv");
    session_start();

    session_destroy();

    header("Location: ./");