@ECHO OFF
cd tests
phpunit
pause
cd ..
behat --out="reports\behat\result.html" --format="html"
exit