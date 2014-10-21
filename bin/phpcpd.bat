@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/sebastian/phpcpd/phpcpd
php "%BIN_TARGET%" %*
