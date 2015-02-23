# Student Robotics Media Consent Access

This is deployed onto the server at /mediaconsent so that users can get
customised forms for completion.

The `.htaccess` file causes the get-mcf.php file to be treated as the index.
It calls onwards to the PDF generation handling present in the `tickets`
submodule which is configured by puppet to use the form.svg in this repo
as the bases for the generated PDFs.
