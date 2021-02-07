<?php
    function validateInputs(string $value): string {
        return htmlentities($value);
    }