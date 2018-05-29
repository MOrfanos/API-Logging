Laravel project where:

• there are users and api keys stored in mysql tables
• every time a user makes a call, the call details are logged in a table called Log
• given an api key that belongs to user 1, we can make a call (e.g. with Postman) to /user/1 and get a JSON back with the user 1 details. API key can be inserted in a header or in a cookie.
• users should only be able to access their own user with their key. All attempts to access another user return an error
• All errors are handled nicely. e.g. wrong api key, no api key, non existing users, non existing resources

------------------------------------------------------------------------------------------------------------------------

The main points of interest in the project are the following:

app/http/routes.php
app/http/controllers/UserController.php
app/http/controllers/APIBaseController.php
app/exceptions/Handler.php