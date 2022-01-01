<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */

function is_greeting($message)
{
    $words = ['halo', 'selamat', 'hai', 'hei', 'p'];
    $message = explode(' ', $message);
    foreach ($words as $word) {
        if (in_array($word, $message)) {
            return true;
        }
    }
}

function is_thanks($message)
{
    $words = ['terimakasih', 'terima', 'kasih', 'tq', 'thank'];
    $message = explode(' ', $message);
    foreach ($words as $word) {
        if (in_array($word, $message)) {
            return true;
        }
    }
}