<?php

$suggested_password = generate_password();
$heading = 'Create Account';
view('userAccounts/create.view.php', compact('suggested_password', 'heading'));
