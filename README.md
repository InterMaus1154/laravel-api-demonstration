# Laravel REST API demonstration - with custom token logic
## In this branch, the same functionality as in master, but instead of sanctum, I am using a custom token logic

### UserToken:
- stores user id (associated user with token)
- token (random 64 chars length string)
- revoked at (default: null, the timestamp when the token was invalidated)

### ApiAuthMiddleware:
- checks if token is valid
- on valid token, sets the request->user() to the user, to whom the token belongs

### AuthController:
- on login/register, a random 64 char string is created and associated with the user
- on logout, the revoked_at date is set, hence invalidating the token for further requests
